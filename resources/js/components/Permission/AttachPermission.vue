<!-- Attach Permission Vue -->
<template>
    <div class="col">
        <a @click="attachPermission()">
            <button class="btn btn-secondary btn-sm rounded-pill w-100">
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
           attachPermission()
            {
                axios.post(this.route)
                .then(response => {
                    window.location.href = this.refreshRoute;
                });
            }
        },
    }
</script>
