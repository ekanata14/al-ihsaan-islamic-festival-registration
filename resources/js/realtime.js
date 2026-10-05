import './echo';

/*
|--------------------------------------------------------------------------
| Realtime table refresh
|--------------------------------------------------------------------------
|
| Server-rendered Blade tetap dipakai. Saat event broadcast masuk, container
| yang punya token resource cocok akan di-refresh: fetch halaman saat ini
| (query search/page ikut terbawa), ekstrak container dengan id sama, swap.
|
*/

const ADMIN_EVENTS = {
    'admin.data.changed': (payload) => payload.resource,
    'registration.created': () => 'registration',
    'khitan.registration.created': () => 'khitan-registration',
    'checkin.recorded': () => 'check-in',
    'activity.logged': () => 'activity-log',
};

const USER_EVENTS = {
    'user.data.changed': (payload) => {
        if (payload.resource === 'registration') return 'user-registration';
        if (payload.resource === 'khitan-registration') return 'user-khitan';
        return payload.resource;
    },
};

const REFRESH_DELAY = 300;
const pending = {};

function containersFor(resource) {
    return Array.from(document.querySelectorAll('[data-realtime]')).filter((el) => {
        const tokens = (el.dataset.realtime || '').split(/\s+/);
        return tokens.includes(resource) || tokens.includes('*');
    });
}

function scheduleRefresh(resource) {
    if (!containersFor(resource).length) return;

    clearTimeout(pending[resource]);
    pending[resource] = setTimeout(() => refreshResource(resource), REFRESH_DELAY);
}

async function refreshResource(resource) {
    const containers = containersFor(resource);
    if (!containers.length) return;

    let doc;
    try {
        const response = await fetch(window.location.href, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', Accept: 'text/html' },
            credentials: 'same-origin',
        });
        if (!response.ok) return;
        doc = new DOMParser().parseFromString(await response.text(), 'text/html');
    } catch (error) {
        return;
    }

    containers.forEach((container) => {
        const fresh = container.id ? doc.getElementById(container.id) : null;
        if (!fresh) return;
        container.replaceWith(fresh);
        flash(fresh);
    });
}

function flash(el) {
    el.classList.add('realtime-flash');
    setTimeout(() => el.classList.remove('realtime-flash'), 1500);
}

function notify(message) {
    if (!window.Swal || !message) return;
    window.Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'info',
        title: message,
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true,
    });
}

function subscribe() {
    if (!window.Echo || !window.__realtime) return;

    const { admin, userId } = window.__realtime;
    const channel = admin
        ? window.Echo.private('admin')
        : userId
          ? window.Echo.private('user.' + userId)
          : null;

    if (!channel) return;

    const events = admin ? ADMIN_EVENTS : USER_EVENTS;

    Object.entries(events).forEach(([event, resolve]) => {
        channel.listen('.' + event, (payload) => {
            const resource = resolve(payload || {});
            if (resource) scheduleRefresh(resource);
            if (payload && payload.message) notify(payload.message);
        });
    });
}

// Konfirmasi hapus pakai event delegation agar tetap aktif setelah tabel di-swap.
// Dipasang di fase capture + stopPropagation supaya tidak dobel dengan handler
// per-halaman yang lama (mereka mem-bind .delete-form saat DOMContentLoaded).
document.addEventListener(
    'submit',
    (event) => {
        const form = event.target.closest('.delete-form');
        if (!form || form.dataset.confirmed === '1' || !window.Swal) return;

        event.preventDefault();
        event.stopPropagation();
        window.Swal.fire({
            title: form.dataset.confirmTitle || 'Hapus data ini?',
            text: form.dataset.confirmText || 'Data yang dihapus tidak bisa dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#1D6594',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
        }).then((result) => {
            if (result.isConfirmed) {
                form.dataset.confirmed = '1';
                form.submit();
            }
        });
    },
    true,
);

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', subscribe);
} else {
    subscribe();
}
