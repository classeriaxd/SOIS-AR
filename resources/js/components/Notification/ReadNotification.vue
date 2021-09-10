<template>
    <div class="row">     
        <div class="col-10">
            <a class="dropdown-item" v-bind:href="link" @click="readNotification()">
                <h4>{{ title }}</h4>
                <p>{{ description }}</p>
            </a>
        </div>
        <div class="col-2">
            <button class="btn w-100 h-100 shadow-none" v-bind:disabled="disableButton" @click="readNotification()" @click.stop>
                <a class="badge badge-pill badge-primary" v-text="badgeText"></a>
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
        },

        props: {
            notification_id: Number,
            read: Boolean,
            title: String,
            description: String,
            link: String,

        },

        data: function(){
            return {
                isRead: this.read,
            }
        },

        computed: {
            // If Notification is read, change badgeText and disable Button
            badgeText(){
                return (this.isRead) ? '' : '\xa0';
            },
            disableButton(){
                return (this.isRead) ? true : false;
            },

        },

        methods:{
            readNotification()
            {
                // Get Notification Id Property then mark as Read
                axios.post('/u/notification/' + this.$props.notification_id)
                    .then(response => {
                        this.isRead = ! this.isRead;
                        console.log(response.data);
                    });
            }
        },
    }
</script>
