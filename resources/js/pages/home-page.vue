<template>
<div class="container">
        <div class="row justify-content-center">

            <div class="col-12 col-md-4">
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-4 d-flex">
                            <b-icon-people class="m-auto" width="32" height="32" />
                        </div>
                        <div class="col-8">
                            <div class="card-body">
                                <h5 class="card-title">{{ classroomCount }}</h5>
                                <p class="card-text"><small class="text-muted">Классов</small></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-4 d-flex">
                            <b-icon-person class="m-auto" width="32" height="32" />
                        </div>
                        <div class="col-8">
                            <div class="card-body">
                                <h5 class="card-title">{{ studentCount }}</h5>
                                <p class="card-text"><small class="text-muted">Учеников</small></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-4 d-flex">
                            <b-icon-clipboard class="m-auto" width="32" height="32" />
                        </div>
                        <div class="col-8">
                            <div class="card-body">
                                <h5 class="card-title">{{ reportCount }}</h5>
                                <p class="card-text"><small class="text-muted">Отчётов</small></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
import { BIconClipboard, BIconPerson, BIconPeople } from 'bootstrap-icons-vue';
import { useObservable } from '@vueuse/rxjs'
import { database } from '@/watermelondb';

export default {
    components: {
        BIconClipboard, BIconPerson, BIconPeople
    },
    setup() {
        return {
            classroomCount: useObservable(database.get('classrooms').query().observeCount()),
            studentCount: useObservable(database.get('students').query().observeCount()),
            reportCount: useObservable(database.get('reports').query().observeCount()),
        }
    }
}
</script>

