<template>
    <div>

        <form v-on:submit.prevent="addUser()">
            <br>
            <div class="field">
                <label class="label">Username</label>
                <div class="control has-icons-left has-icons-right">
                    <input class="input" type="text" placeholder="e.g Alex Smith" v-model="user.name" required>
                    <span class="icon is-small is-left">
                    <i class="fas fa-user"></i>
                </span>
                </div>
            </div>

            <div class="field">
                <label class="label">Email</label>
                <div class="control has-icons-left has-icons-right">
                    <input class="input" type="email" placeholder="e.g. alexsmith@gmail.com" v-model="user.email" required>
                    <span class="icon is-small is-left">
                    <i class="fas fa-envelope"></i>
                </span>
                </div>
            </div>

            <div class="field">
                <label class="label">Info</label>
                <div class="control">
                    <textarea class="textarea" placeholder="Other Info" v-model="user.info"></textarea>
                </div>
            </div>


            <div class="field is-grouped">
                <div class="control">
                    <button type="submit" class="button is-link">Submit</button>
                </div>
                <div class="control">
                    <button type="reset" class="button is-link is-light">Cancel</button>
                </div>
            </div>
        </form>

        <h1 class="title is-1" style="text-align: center">Users</h1>
        <h1 class="title is-4" style="text-align: center">Page {{pagination.current_page}} of
            {{pagination.last_page}}</h1>
        <nav class="pagination is-medium" role="navigation" aria-label="pagination">
            <button class="button pagination-previous has-background-link has-text-white"
                    v-bind="[{disabled: !pagination.prev_page_url}]"
                    v-on:click="fetchUsers(pagination.prev_page_url)">Previous
            </button>

            <button class="button pagination-next has-background-link has-text-white"
                    v-bind="[{disabled: !pagination.next_page_url}]"
                    v-on:click="fetchUsers(pagination.next_page_url)">Next page
            </button>
        </nav>
        <div class="box has-background-light" v-for="user in users">
            <h1 class="title is-4">{{user.name}}</h1>
            <h1 class="subtitle">{{user.email}}</h1>
            <p>{{user.info}}</p>
            <hr class="has-background-primary">
            <div style="text-align: right">
                <button v-on:click="editUser(user)" class="button is-warning">Edit</button>
                <button v-on:click="deleteUser(user.id)" class="button is-danger">Delete</button>
            </div>
        </div>

        <h1 class="title is-4" style="text-align: center">Page {{pagination.current_page}} of
            {{pagination.last_page}}</h1>

        <nav class="pagination is-medium" role="navigation" aria-label="pagination">
            <button class="button pagination-previous has-background-link has-text-white"
                    v-bind="[{disabled: !pagination.prev_page_url}]"
                    v-on:click="fetchUsers(pagination.prev_page_url)">Previous
            </button>

            <button class="button pagination-next has-background-link has-text-white"
                    v-bind="[{disabled: !pagination.next_page_url}]"
                    v-on:click="fetchUsers(pagination.next_page_url)">Next page
            </button>
        </nav>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                users: [],
                user: {
                    id: '',
                    name: '',
                    email: '',
                    info: ''
                },
                pagination: {},
                edit: false
            }
        },

        created() {
            this.fetchUsers();
        },

        methods: {
            fetchUsers(page_url) {
                let vm = this;
                page_url = page_url || 'api/users';
                fetch(page_url)
                    .then(res => res.json())
                    .then(response => {
                        this.users = response.data;
                        console.log(response);
                        vm.makePagination(response.meta, response.links);
                    })
                    .catch(err => console.log(err))
            },
            deleteUser(id) {
                if (confirm('confirm delete ?')) {
                    fetch(`api/users/${id}`, {
                        method: 'delete'
                    }).then(res => res.json())
                        .then(data => {
                            // alert('user removed');
                            this.fetchUsers();
                        })
                        .catch(err => console.log(err))
                }
            },
            addUser() {
                if (this.edit === false){
                    //ADD
                    fetch('api/users',{
                        method:'POST',
                        body: JSON.stringify(this.user),
                        headers:{'content-type': 'application/json'}
                    }).then(res =>res.json())
                        .then(data =>{
                            this.user.id = '';
                            this.user.name = '';
                            this.user.email = '';
                            this.user.info = '';

                            this.fetchUsers();
                        })
                        .catch(err => console.log(err))
                }else{
                    //UPDATE
                    this.updateUser();
                    this.edit = false;
                }

            },
            editUser(user) {
                this.edit = true;
                this.user.id = user.id;
                this.user.name = user.name;
                this.user.email = user.email;
                this.user.info = user.info;
            },
            updateUser(){
                fetch(`api/users/${this.user.id}`,{
                    method:'put',
                    body: JSON.stringify(this.user),
                    headers:{'content-type':'application/json'}
                }).then(res =>res.json())
                    .then(data=>{
                        this.user.id = '';
                        this.user.name = '';
                        this.user.email = '';
                        this.user.info = '';

                        this.fetchUsers();
                    }).catch(err => console.log(err))
            },
            makePagination(meta, links) {
                this.pagination = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev
                };
            }
        }
    }
</script>