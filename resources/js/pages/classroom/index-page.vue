<template>
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-12 col-lg-4">
                <classroom-list />
            </div>

            <div class="col-8 d-none d-lg-block">
                <div class="card mb-3">
                    <div class="card-body">
                        <h3 class="fs-3">Выберите класс</h3>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
import classroomList from '@components/classroom-list.vue'

export default {
    components: {
        classroomList
    }
}
</script>
