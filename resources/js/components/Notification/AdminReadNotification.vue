<!-- Admin Read Notification -->
<template>
    <div class="row">     
        <div class="col-10">
            <a class="dropdown-item" v-bind:href="link" @click="readNotification()">
                <h4 class="text-truncate">{{ title }}</h4>
                <p class="text-truncate">{{ description }}</p>
            </a>
        </div>
        <div class="col-2">
            <button class="btn w-100 h-100" v-bind:disabled="disableButton" @click="readNotification()" @click.stop>
                <a class="badge rounded-pill bg-primary text-decoration-none shadow" v-text="badgeText"></a>
            </button>
        </div>
    </div>
</template>
<script>
    export default {
        mounted() {
        },

        props: {
            read: Boolean,
            title: String,
            description: String,
            link: String,
            route: String,

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
                axios.post(this.route)
                    .then(response => {
                        this.isRead = ! this.isRead;
                        console.log(response.data);
                    });
            }
        },
    }
</script>
