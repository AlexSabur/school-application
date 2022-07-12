import 'core-js/proposals/array-grouping-stage-3-2';
import 'bootstrap';

import { createApp } from 'vue'
import { createRouter, createWebHashHistory } from 'vue-router';
import { client } from '@/client'
import { database, sync, checkUnsyncedChanges } from '@/watermelondb/index'

let tempHtml = null
let appInstance = null

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

const createApplication = () => {
    const root = document.querySelector('#pwa')
    if (!root) {
        return;
    }

    const app = createApp({})

    app.use(router)

    app.provide('$client', client)
    app.provide('$database', database)

    tempHtml = root.cloneNode(true)

    app.mount(root);

    console.log(tempHtml);

    return app
}

window.$sync = async () => {
    await sync()
}

window.$routePush = (to) => {
    router.push(to)
}

window.$reset = async () => {
    if (!confirm('Локальная версия будет стёрта')) {
        return
    }

    if (appInstance) {
        await router.push({ name: 'home' })

        appInstance.unmount()

        appInstance = null
    }

    const root = document.querySelector('#pwa')

    if (tempHtml && root) {
        root.parentNode.replaceChild(tempHtml, root);
    }

    await database.write(async () => { return await database.unsafeResetDatabase(); });

    await sync();

    appInstance = createApplication()
}

appInstance = createApplication()
