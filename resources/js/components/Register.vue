<template>
    <div class="col-md-4 m-auto text-center">
        <input type="text" class="form-control m-1" placeholder="Имя пользователя" v-model="user.name">
        <input type="text" class="form-control m-1" placeholder="Почта" v-model="user.email">
        <input type="password" class="form-control m-1" placeholder="Пароль" v-model="user.password">
        <button type="submit" class="btn btn-primary m-1" @click="register">Зарегестрироваться</button>
    </div>
</template>
<script>
export default {
    data(){
        return{
            user:{
                name: '',
                email: '',
                password: '',
            }
        }
    },

    created() {
    },
    methods:{
        register(){
            axios.post('api/register', this.user).then(res => {
                Toast.fire({
                    icon: 'success',
                    title: 'Регистрация прошла успешно!'
                })
                this.$router.push('/login');
            })
        }
    }
}

</script>
