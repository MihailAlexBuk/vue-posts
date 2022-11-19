<template>
    <div>
        <!-- Modal -->
        <div
            class="modal fade"
            id="staticBackdrop"
            data-bs-backdrop="static"
            data-bs-keyboard="false"
            tabindex="-1"
            aria-labelledby="staticBackdropLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-if="edit"  id="staticBackdropLabel">Редактирование поста</h5>
                        <h5 class="modal-title" v-else id="staticBackdropLabel">Создание</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" :class="['form-control my-2', errors.title?'is-invalid':'']" placeholder="Заголовок" v-model="post.title">
                        <span v-if="errors.title" class="bg-danger text-white p-1 rounded">{{errors.title[0]}}</span>
                        <textarea type="text" :class="['form-control my-2', errors.body?'is-invalid':'']" placeholder="Содержимое" v-model="post.body"></textarea>
                        <span v-if="errors.body" class="bg-danger text-white p-1 rounded">{{errors.body[0]}}</span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Закрыть</button>
                        <button v-if="edit" type="button" class="btn btn-success" @click="updatePost">Обновить</button>
                        <button v-else type="button" class="btn btn-success" @click="createPost">Создать</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Button trigger modal -->
        <button v-if="user" type="button" class="btn btn-success btn-sm float-end" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            Создать пост
        </button>

        <div v-for="post in posts" :key="post.id" class="my-3">
            <h4>{{post.title}}</h4>
            <p>{{post.body}}</p>
            <button v-if="user" type="button" @click="editPost(post)" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                Редактировать
            </button>
            <button v-if="user" type="button" @click="deletePost(post.id)" class="btn btn-danger btn-sm m-2">
                Удалить
            </button>
        </div>
        <nav class="" style="font-size: 20px">
            <ul class='pagination justify-content-center'>
                <li v-if="pagination.current_page !== 1" class='page-item'>
                    <a class="page-link" @click.prevent='getPosts(pagination.current_page - 1)' href='#'> Назад </a>
                </li>
                <li v-for='link in pagination.links' class="page-item">
                    <template v-if="Number(link.label) &&
                                    (pagination.current_page - link.label < 2 &&
                                    pagination.current_page - link.label > -2) ||
                                    Number(link.label) === 1 || Number(link.label) === pagination.last_page">
                        <a @click.prevent='getPosts(link.label)' :class="['page-link', link.active ? 'active' : '']" href='#'>{{link.label}}</a>
                    </template>
                    <template v-if="Number(link.label) &&
                                    pagination.current_page !== 3 &&
                                    pagination.current_page - link.label === 2 ||
                                    Number(link.label) &&
                                    pagination.current_page !== pagination.last_page - 2 &&
                                    pagination.current_page - link.label === -2
">
                        <a>...</a>
                    </template>
                </li>
                <li v-if="pagination.current_page !== pagination.last_page" class=' mb-5 '>
                    <a class="page-link" @click.prevent='getPosts(pagination.current_page + 1)' href='#'> Вперед </a>
                </li>
            </ul>
        </nav>
    </div>
</template>
<script>
import {mapGetters} from 'vuex'
export default {
    name: 'Post',
    data(){
        return{
            post: {
                title : '',
                body : '',
            },
            posts:{},
            edit: false,
            errors:[],
            pagination: [],
        }
    },

    methods:{
        createPost(){
            let token = localStorage.getItem('token')
            axios.post('api/createpost?token='+token, this.post).then(res => {
                Toast.fire({
                    icon: 'success',
                    title: 'Пост успешно создан!'
                })
                this.errors = []
                this.post = {
                    title : '',
                    body : '',
                }
                this.getPosts()

            }).catch(err => {
                this.errors = JSON.parse(err.request.responseText).errors;
            })
        },

        editPost(post){
            this.post = post;
            this.edit = true;
        },

        deletePost(postId){
            let token = localStorage.getItem('token')

            Swal.fire({
                title: 'Вы уверены?',
                text: "Вы не сможете вернуть обратно!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Вернуться',
                confirmButtonText: 'Да, удалить!'
            }).then((result) => {
                if (result.isConfirmed) {

                    axios.delete('api/deletepost/'+postId+'?token='+token).then(res =>{
                        Swal.fire(
                            'Удалено!',
                            'Ваша статья успешно удален.',
                            'success'
                        )
                        this.getPosts()
                    })

                }
            })
        },

        updatePost(){
            let token = localStorage.getItem('token')
            axios.put('api/updatepost/'+this.post.id+'?token='+token, this.post).then(res => {
                Toast.fire({
                    icon: 'success',
                    title: 'Пост успешно обновлен!'
                })
                this.errors = []
                this.post = {
                    title : '',
                    body : '',
                }
                this.getPosts()
                // this.$router.push({name:'post'})

            }).catch(err => {
                this.errors = JSON.parse(err.request.responseText).errors;
            })
        },

        getPosts(page = 1){
            axios.post('api/getposts', {'page' : page}).then(res => {
                this.posts = res.data.data
                this.pagination = res.data
                // console.log(res.data)
            })
        }
    },

    created() {
        this.getPosts();
    },

    computed:{
        ...mapGetters(['user'])
    }
}
</script>
