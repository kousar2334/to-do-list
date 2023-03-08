<template>
    <div class="list">
        <div class="align-items-center d-flex justify-content-between list-header mt-3">
            <h6 class="mb-0 text-capitalize">{{ list.name }}</h6>
            <div class="list-actions">
                <a href="#" class="text-black" title="Add New Task" @click="data.newTaskModalShow = !data.newTaskModalShow">
                    <font-awesome-icon icon="fas fa-plus" /></a>
                <b-dropdown variant="text" no-caret right text="Right align" title="More Actions">
                    <template #button-content>
                        <font-awesome-icon icon="fas fa-ellipsis" />
                    </template>
                    <b-dropdown-item href="#" @click="editList"> <font-awesome-icon icon="fas fa-pencil" />
                        Edit</b-dropdown-item>
                    <b-dropdown-item href="#" class="text-danger" @click="deleteList"> <font-awesome-icon
                            icon="fas fa-trash-alt" />
                        Delete</b-dropdown-item>
                </b-dropdown>
            </div>
        </div>

        <div class="tasks-body p-0">
            <task-item v-for="(task, index) in data.tasks" :task="task" :key="index" @delete-task="deleteTask"
                @edit-task="editTask" @change-status="changeStatus">
            </task-item>
        </div>
        <!--New Task modal-->
        <b-modal v-model="data.newTaskModalShow" title="Create New Task" hide-footer>
            <b-container fluid>
                <div class="form-group pb-3">
                    <label class="mb-2">Task Name</label>
                    <input type="text" placeholder="Name" class="form-control" v-model="data.newTask">
                    <template v-if="data.errors.name">
                        <p class="fz-12 text-danger mt-1 mb-0" v-for="(error, index) in data.errors.name" :key="index">
                            {{ error }}
                        </p>
                    </template>
                </div>
                <div class="m-0 row">
                    <button class="btn btn-primary" :class="{ loading: data.submit_data }"
                        @click.prevent="storeNewTask">Save</button>
                </div>
            </b-container>
        </b-modal>
        <!--End New Task modal-->
        <!--Task Edit modal-->
        <b-modal v-model="data.taskUpdateModalShow" title="Update Task" hide-footer>
            <b-container fluid>
                <div class="form-group pb-3">
                    <label class="mb-2">Task Name</label>
                    <input type="text" placeholder="Name" class="form-control" v-model="data.editTask.name">
                    <template v-if="data.errors.name">
                        <p class="fz-12 text-danger mt-1 mb-0" v-for="(error, index) in data.errors.name" :key="index">
                            {{ error }}
                        </p>
                    </template>
                </div>
                <div class="m-0 row">
                    <button class="btn btn-primary" :class="{ loading: data.submit_data }" @click.prevent="updateTask">
                        Save Change
                    </button>
                </div>
            </b-container>
        </b-modal>
        <!--End Task edit modal-->
    </div>
</template>
<script>
import axios from "axios";
import { defineComponent, reactive } from "vue";
import { useToast } from "vue-toastification";
import TaskItem from './TaskItem.vue';
import { useStore } from 'vuex';
import { onMounted } from "vue";
export default defineComponent({
    name: "List",
    components: { TaskItem },
    props: {
        list: {
            type: Object,
            required: true,
        }
    },
    setup(props, { emit }) {
        const data = reactive({
            errors: [],
            submit_data: false,
            newTask: "",
            tasks: [],
            editTask: {},
            newTaskModalShow: false,
            listEditModalShow: false,
            taskUpdateModalShow: false,
            currentPage: 1,
        });
        const toast = useToast();
        const store = useStore();
        const config = {
            headers: {
                Authorization: `Bearer ${store.getters.userToken}`,
            },
        }

        onMounted(() => {
            getTasks();
        });
        function editList() {
            emit('showListEditModal', props.list);
        }

        function deleteList() {
            emit('deleteList', props.list.id);
        }

        function storeNewTask() {
            data.submit_data = true;
            data.errors = [];
            axios.post('api/v1/store-task', {
                name: data.newTask,
                todo_list_id: props.list.id
            }, config).then((response) => {
                if (response.data.success) {
                    data.newTaskModalShow = false;
                    data.newTask = "";
                    getTasks();
                }
                if (!response.data.success) {
                    toast.error("Task create failed");
                }
                data.submit_data = false;
            }).catch((error) => {
                data.submit_data = false;
                if (error.response.status == 422) {
                    data.errors = error.response.data.errors;
                }
                if (!error.response.status == 422) {
                    toast.error("Task create failed");
                }

            });
        }

        function editTask(task) {
            data.editTask = task;
            data.taskUpdateModalShow = true;
        }
        function changeStatus(id) {
            axios.post('api/v1/change-task-status', {
                id: id,
            }, config).then((response) => {
                if (response.data.success) {
                    getTasks();
                }
                if (!response.data.success) {
                    toast.error("Status update failed");
                }
            }).catch((error) => {
                toast.error("Status update failed");
            });
        }

        function getTasks() {
            data.tasks = [];
            axios.post('api/v1/task-lists', {
                page: data.currentPage,
                list_id: props.list.id
            }, config).then((response) => {
                if (response.data.success) {
                    data.tasks = response.data.data;
                }
                if (!response.data.success) {
                    data.tasks = [];
                }
            }).catch((error) => {
                data.tasks = [];
            });
        }

        function updateTask() {
            data.submit_data = true;
            data.errors = [];
            axios.post('api/v1/update-task', {
                name: data.editTask.name,
                id: data.editTask.id,
                todo_list_id: props.list.id
            }, config).then((response) => {
                if (response.data.success) {
                    data.taskUpdateModalShow = false;
                    data.editTask = {};
                    getTasks();
                }
                if (!response.data.success) {
                    toast.error("Task Update failed");
                }
                data.submit_data = false;
            }).catch((error) => {
                data.submit_data = false;
                if (error.response.status == 422) {
                    data.errors = error.response.data.errors;
                }
                if (!error.response.status == 422) {
                    toast.error("Task update failed");
                }

            });
        }

        function deleteTask(id) {
            axios.post('api/v1/delete-task', {
                id: id,
            }, config).then((response) => {
                if (response.data.success) {
                    getTasks();
                    toast.success("Task deleted successfully");
                }
                if (!response.data.success) {
                    toast.error("Task delete failed");
                }
            }).catch((error) => {
                toast.error("Task delete failed");
            });
        }
        return {
            data,
            storeNewTask,
            getTasks,
            editList,
            deleteList,
            deleteTask,
            editTask,
            updateTask,
            changeStatus
        };
    },

})
</script>