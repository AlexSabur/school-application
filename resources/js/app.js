import 'core-js/proposals/array-grouping-stage-3-2';
import 'bootstrap';

import { createApp } from 'vue'
import { createRouter, createWebHashHistory } from 'vue-router';
import { client } from '@/client'
import { database, sync, checkUnsyncedChanges } from '@/watermelondb/index'

window.sync = sync
window.checkUnsyncedChanges = checkUnsyncedChanges
window.client = client
window.database = database

const app = createApp({
    created() {
        // setInterval(() => sync(), 5000)
    }
})

app.provide('$client', client)
app.provide('$database', database)

const router = createRouter({
    history: createWebHashHistory(),
    routes: [
        { name: 'home', path: '/', component: () => import(/* webpackChunkName: "main-pages" */ '@pages/home-page.vue') },
        //
        { name: 'classroom.index', path: '/classrooms', component: () => import(/* webpackChunkName: "classroom-pages" */ '@pages/classroom/index-page.vue') },
        { name: 'classroom.create', path: '/classrooms/create', component: () => import(/* webpackChunkName: "classroom-pages" */ '@pages/classroom/create-page.vue') },
        { name: 'classroom.show', path: '/classrooms/:classroom', component: () => import(/* webpackChunkName: "classroom-pages" */ '@pages/classroom/show-page.vue') },
        { name: 'classroom.edit', path: '/classrooms/:classroom/edit', component: () => import(/* webpackChunkName: "classroom-pages" */ '@pages/classroom/edit-page.vue') },
        //
        { name: 'classroom.student.create', path: '/classrooms/:classroom/students/create', component: () => import(/* webpackChunkName: "classroom-pages" */ '@pages/student/create-page.vue') },
        { name: 'classroom.student.show', path: '/classrooms/:classroom/students/:student', component: () => import(/* webpackChunkName: "classroom-pages" */ '@pages/student/show-page.vue') },
        { name: 'classroom.student.edit', path: '/classrooms/:classroom/students/:student/edit', component: () => import(/* webpackChunkName: "classroom-pages" */ '@pages/student/edit-page.vue') },
        //
        { name: 'report.index', path: '/reports', component: () => import(/* webpackChunkName: "report-pages" */ '@pages/report/index-page.vue') },
        { name: 'report.create', path: '/reports/create', component: () => import(/* webpackChunkName: "report-pages" */ '@pages/report/create-page.vue') },
        { name: 'report.show', path: '/reports/:report', component: () => import(/* webpackChunkName: "report-pages" */ '@pages/report/show-page.vue') },
        { name: 'report.edit', path: '/reports/:report/edit', component: () => import(/* webpackChunkName: "report-pages" */ '@pages/report/edit-page.vue') },
        //
        { name: 'report.record.index', path: '/reports/:report/add', component: () => import(/* webpackChunkName: "report-pages" */ '@pages/record/index-page.vue') },
        { name: 'report.record.classroom', path: '/reports/:report/add/:classroom', component: () => import(/* webpackChunkName: "report-pages" */ '@pages/record/classroom-page.vue') },
        { name: 'report.record.edit', path: '/reports/:report/:record', component: () => import(/* webpackChunkName: "report-pages" */ '@pages/record/edit-page.vue') },
    ]
})

app.use(router)

const root = document.querySelector('#pwa')

if (root) {
    app.mount(root);
}

window.$routePush = (to) => {
    router.push(to)
}

window.$reset = async () => {
    if (!confirm('Локальная версия будет стёрта')) {
        return
    }
    await database.write(async () => { return await database.unsafeResetDatabase(); });
    await sync();
    location.reload();
}

import { Workbox } from 'workbox-window';

if ('serviceWorker' in navigator) {
    const wb = new Workbox('/service-worker.js');

    wb.register();
}

// if ('serviceWorker' in navigator) {
//     const wb = new Workbox('/service-worker.js')

//     wb.addEventListener('install', (event) => {
//         event.waitUntil(caches.open('v1').then(cache => {
//             return cache.addAll()
//         }))
//     })

//     wb.addEventListener('fetch', (event) => {
//         event.respondWith(caches.match(event.request).then(response => {
//             if (response)
//                 return response;
//             return fetch(event.request)
//         }))
//     })

//     window.addEventListener('load', async () => {
//         await wb.register('service-worker.js')
//     })
// }
