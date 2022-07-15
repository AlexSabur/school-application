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
        { name: 'classroom.delete', path: '/classrooms/:classroom/delete', component: () => import(/* webpackChunkName: "classroom-pages" */ '@pages/classroom/delete-page.vue') },
        //
        { name: 'classroom.student.create', path: '/classrooms/:classroom/students/create', component: () => import(/* webpackChunkName: "classroom-pages" */ '@pages/student/create-page.vue') },
        { name: 'classroom.student.upload', path: '/classrooms/:classroom/students/upload', component: () => import(/* webpackChunkName: "classroom-pages" */ '@pages/student/upload-page.vue') },
        { name: 'classroom.student.show', path: '/classrooms/:classroom/students/:student', component: () => import(/* webpackChunkName: "classroom-pages" */ '@pages/student/show-page.vue') },
        { name: 'classroom.student.edit', path: '/classrooms/:classroom/students/:student/edit', component: () => import(/* webpackChunkName: "classroom-pages" */ '@pages/student/edit-page.vue') },
        { name: 'classroom.student.delete', path: '/classrooms/:classroom/students/:student/delete', component: () => import(/* webpackChunkName: "classroom-pages" */ '@pages/student/delete-page.vue') },
        //
        { name: 'report.index', path: '/reports', component: () => import(/* webpackChunkName: "report-pages" */ '@pages/report/index-page.vue') },
        { name: 'report.create', path: '/reports/create', component: () => import(/* webpackChunkName: "report-pages" */ '@pages/report/create-page.vue') },
        { name: 'report.show', path: '/reports/:report', component: () => import(/* webpackChunkName: "report-pages" */ '@pages/report/show-page.vue') },
        { name: 'report.edit', path: '/reports/:report/edit', component: () => import(/* webpackChunkName: "report-pages" */ '@pages/report/edit-page.vue') },
        { name: 'report.delete', path: '/reports/:report/delete', component: () => import(/* webpackChunkName: "report-pages" */ '@pages/report/delete-page.vue') },
        //
        { name: 'report.record.index', path: '/reports/:report/add', component: () => import(/* webpackChunkName: "report-pages" */ '@pages/record/index-page.vue') },
        { name: 'report.record.classroom', path: '/reports/:report/add/:classroom', component: () => import(/* webpackChunkName: "report-pages" */ '@pages/record/classroom-page.vue') },
        { name: 'report.record.edit', path: '/reports/:report/:record', component: () => import(/* webpackChunkName: "report-pages" */ '@pages/record/edit-page.vue') },
        { name: 'report.record.delete', path: '/reports/:report/:record/delete', component: () => import(/* webpackChunkName: "report-pages" */ '@pages/record/delete-page.vue') },
    ]
})

const createApplication = (goSync = true) => {
    const root = document.querySelector('#pwa')
    if (!root) {
        return;
    }

    const app = createApp()

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

window.$reset = async (forse = false) => {
    if (!forse) {
        if (!confirm('Локальная версия будет стёрта')) {
            return
        }
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

    appInstance = createApplication(false)
}

appInstance = createApplication()

class Synchronization {
    // nowsync = false

    constructor() {
        // this.created = localStorage.getItem('synced');

        this.onlineSubscribe()
    }

    onlineSubscribe() {
        this.online = navigator.onLine

        window.addEventListener('offline', () => {
            this.online = false;
        });

        window.addEventListener('online', () => {
            this.online = true;
        });
    }

    slleep(sllep = 5000) {
        return new Promise((reject) => {
            setTimeout(() => {
                reject()
            }, sllep);
        })
    }

    async sync() {
        try {
            if (this.online) {
                await sync()

            } else {
                await this.slleep(10000)
            }

            await this.slleep(5000)
        } catch (error) {
            console.error(error);

            await this.slleep(10000)
        }

        this.sync()
    }
}

(new Synchronization()).sync()
