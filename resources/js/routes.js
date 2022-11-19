import Login from "./components/Login";
import Register from "./components/Register";
import Post from "./components/Post";
import { createRouter, createWebHistory } from 'vue-router'


const router = createRouter({
    history: createWebHistory(),
    routes: [
        {path: '/login', component:Login, name:'login'},
        {path: '/register', component:Register, name:'register'},
        {path: '/post', component:Post, name:'post'},
    ],
})

export default router




