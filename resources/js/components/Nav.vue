<template>
    <div class="text-center mb-5">
        <router-link v-if="!user" to="login" class="btn btn-primary m-1">Войти</router-link>
        <router-link v-if="!user" to="register" class="btn btn-primary m-1">Регистрация</router-link>
        <router-link to="post" class="btn btn-primary m-1">Статьи</router-link>
        <button v-if="user" class="btn btn-primary m-1" @click="logout">Выйти</button>
    </div>
</template>
<script>
    import {mapGetters} from 'vuex'
    export default{
        name: 'Nav',

        data(){
            return{
            }
        },

        methods:{
            logout(){
                Swal.fire({
                    title: 'Вы хотите выйти?',
                    text: "Вы всегда сможете вернуться обратно!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Вернуться',
                    confirmButtonText: 'Да, выйти!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let token = localStorage.getItem('token')
                        axios.post('api/logout?token='+token).then(res=>{
                            Toast.fire({
                                icon: 'success',
                                title: 'Возвращайтесь скорей!'
                            })
                            localStorage.setItem('token', '')
                            this.$store.dispatch('user', null)
                            this.$router.push('/post')
                        })
                    }
                })
            }
        },
        computed:{
        ...mapGetters(['user'])
        }
    }
</script>
