<template>
    <div class="container mb-5">
        <Nav></Nav>
        <router-view ></router-view>
    </div>
</template>
<script>
    import Nav from './Nav'
export default{
    name: 'App',
    components:{
        Nav,
    },

    created() {
        this.getUser()
    },

    methods:{
        getUser(){
            axios.post('api/user?token='+localStorage.getItem('token')).then(res =>{
                this.$store.dispatch('user', res.data)
            }).catch(err =>{

            })
        }
    }
}
</script>
