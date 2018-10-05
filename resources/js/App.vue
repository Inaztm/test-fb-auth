<template>
    <div class="big-wrapper">
        <section v-if="!isAuth">
            <div class="text-center">
                <a class="btn btn-primary" href="/auth/redirect">
                    Login with facebook
                </a>
            </div>
        </section>
        <section v-else>
            <div class="card text-center" style="width: 18rem;">
                <div class="card-body">
                    <img
                        class="img-thumbnail"
                        :src="user.avatar"
                        alt="User avatar">
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ user.name }}</h5>
                    <a
                        href="#"
                        class="btn btn-primary"
                        @click="logout">
                        Log out
                    </a>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'app',
    data () {
        return {
            isAuth: window.isAuth ? window.isAuth : false,
            user: window.user ? window.user : null
        };
    },
    methods: {
        logout () {
            axios.post('/logout')
                .then(({ data }) => {
                    this.isAuth = data.isAuth
                    this.user = null
                })
        }
    }
}
</script>
