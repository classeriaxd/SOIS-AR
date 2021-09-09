<template>
    <div class="btn notification" @click="readNotification()">
        <a class="badge badge-pill badge-primary">&nbsp;</a>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        methods:{
            readNotification()
            {
                var yeet = this.$props.notification_id;
                console.log(yeet);
            }
        },
        props: {
            notification_id: Number,
        }
    }
</script>
