<template>
    <div class="col-md-4 m-auto text-center">
        <div v-if="error" class="alert alert-danger">Неверный логин или пароль!!</div>
        <input type="text" class="form-control m-1" placeholder="Имя пользователя" v-model="user.name">
        <input type="password" class="form-control m-1" placeholder="Пароль" v-model="user.password">
        <button type="submit" class="btn btn-primary m-1 w-50" @click="login">Войти</button>
    </div>
</template>
<script>
    export default {
        data(){
            return{
                user:{
                    name: '',
                    password: '',
                },
                error: false,
            }
        },

        created() {
        },

        methods:{
            login(){
                axios.post('api/login', this.user).then(res => {
                    if(res.data.status == 'success'){
                        localStorage.setItem('token', res.data.token)
                        this.error = false

                        Toast.fire({
                            icon: 'success',
                            title: 'Приветствую вас, '+res.data.user+'!'
                        })
                        this.$store.dispatch('user', res.data.user)

                        this.$router.push('/post')
                    }else{
                        this.error = true
                    }
                })
            }
        }
    }

</script>
