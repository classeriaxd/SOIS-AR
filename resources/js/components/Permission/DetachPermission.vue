<!-- Detach Permission Vue -->
<template>
    <div class="col">
        <a @click="detachPermission()">
            <button class="btn btn-primary btn-sm text-white rounded-pill w-100">
                {{ permissionName }}
            </button>
        </a>
    </div>
</template>
<script>
    export default {
        mounted() {
        },

        props: {
            permissionName: String,
            route: String,
            refreshRoute: String,
        },

        methods:{
            detachPermission()
            {
                axios.post(this.route)
                .then(response => {
                    window.location.href = this.refreshRoute;
                });
            }
        },
    }
</script>
