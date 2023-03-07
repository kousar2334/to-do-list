<template>
    <div class="tasks">
        <div class="task-header">
            <h6>{{ list.name }}</h6>
        </div>
        <div class="d-flex justify-content-center mb-3 rounded-1 tasks__item__toggle">
            <a @click="data.newTaskModalShow = !data.newTaskModalShow">
                + Add New Task
            </a>
        </div>
        <div class="tasks-body p-0">
            <task-item v-for="(task, index) in data.tasks" @remove="removeTask(index)" @complete="completeTask(task)"
                :task="task" :key="task">
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
    setup(props) {
        const data = reactive({
            errors: [],
            submit_data: false,
            newTask: "",
            tasks: [],
            newTaskModalShow: false,
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

        function getTasks() {
            axios.post('api/v1/task-lists', {
                page: data.currentPage,
                list_id: props.list.id
            }, config).then((response) => {
                if (response.data.success) {
                    data.tasks = response.data.data;
                    data.currentPage = response.data.meta.current_page
                }
                if (!response.data.success) {
                    data.tasks = [];
                }
            }).catch((error) => {
                data.tasks = [];
            });
        }

        return {
            data,
            storeNewTask,
            getTasks,
        };
    },

})
</script>