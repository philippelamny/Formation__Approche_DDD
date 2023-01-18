
let TodoList = {
    props: {
    },
    created: function() {
        this.loadTodoList()
    },
    computed: {
        todoListChecked() {
            return this.todolist.filter((item) => {
                return item.isChecked;
            })
        },
        todoListNotChecked() {
            return this.todolist.filter((item) => {
                return !item.isChecked;
            })
        },
    },
    data() {
        return {
            todolist: [],
            loading: true,
            newItemName: ""
        };
    },
    methods: {
        removeItem(id) {
            const that = this
           
            that.loading = true
            fetch(`api/todolist/${id}`, {method: "DELETE"})
            .then((response) => {
                that.loadTodoList()
            })
            .finally(() => {
                that.loading = false
            })
            .catch((e) => alert(e.message))
        },
        loadTodoList() {
            const that = this
            fetch('api/todolist')
            .then((response) => {    
                return response.json().then(function(json) {
                    that.todolist = json
                })
            })
            .catch((e) => alert(e.message))
            .finally(() => that.loading = false)
        },
        addItem() {
            const that = this
            if (that.newItemName.length == 0) {
                alert("Name need to be specified")
                return
            }

            that.loading = true
            fetch("api/todolist", {
                method: "POST",
                body: JSON.stringify({
                    "name": that.newItemName
                }),
                headers: {
                    'Content-type': 'application/json; charset=UTF-8'
                }
            }).then((response) => {
                if (response.ok) {
                    that.loadTodoList()
                    that.newItemName = ""
                }
                
            })
            .finally(() => {
                that.loading = false
            })
            .catch((e) => alert(e.message))
        },
        allowDrop(ev) {
            ev.preventDefault();
        },
        startDrag(evt, item) {
            console.log('start drag');
            evt.dataTransfer.dropEffect = 'move'
            evt.dataTransfer.effectAllowed = 'move'
            evt.dataTransfer.setData('itemID', item.id)
        },
        onDrop(evt, list) {
            console.log('drop');
            const itemID = evt.dataTransfer.getData('itemID')
            const item = this.todolist.find((item) => item.id == itemID)
            console.log(item)
        },
    },
    template: `
        <div id="content-for-todolist" class="container-fluid">
            <div v-if="loading" class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <div v-else>
                <div class="input-group mb-3">
                    <input type="text" v-model="newItemName" class="form-control" placeholder="New Todo Item" aria-label="New Todo Item" aria-describedby="button-addon2">
                    <button v-on:click="addItem" class="btn btn-outline-secondary" type="button" id="button-addon2">Add</button>
                </div>
                <div class="row">
                    <div class="col">
                        <h2>Unchecked Items</h2>
                        <ul class="list-group container">
                            <li 
                                v-for="item in todoListNotChecked" 
                                :key="item.id" 
                                draggable="true"
                                class="list-group-item list-group-item-action"
                            >
                                <button v-on:click="removeItem(item.id)" type="button" class="btn btn-danger">-</button>    
                                <span>{{ item.name }}</span>
                            </li>
                        </ul>
                    </div>

                    <div class="col">
                        <h2>Checked Items</h2>
                        <ul class="list-group container" ondrop="dropItem(event)">
                            <li 
                                draggable="true" 
                                v-for="item in todoListChecked" 
                                :key="item.id" 
                                class="list-group-item list-group-item-action"
                            >
                                <button v-on:click="removeItem(item.id)" type="button" class="btn btn-danger">-</button>    
                                <span>{{ item.name }}</span>
                            </li>
                        </ul>
                    </div>
                    
                </div>
            </div>
        </div>
    `
};


const { createApp } = Vue

createApp({
    data() {
        return {
            message: 'Hello Vue!'
        }
    }
})
.component('todo-list', TodoList)
.mount('#app')
