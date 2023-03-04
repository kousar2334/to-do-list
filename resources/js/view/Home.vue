<template>
    <div class="row">
        <div class="col-lg-3">
            <div class="tasks">
                <div class="task-header">
                    <h6>Task List</h6>
                </div>
                <div class="tasks-body p-0">
                    <task-item v-for="(task, index) in tasks" @remove="removeTask(index)" @complete="completeTask(task)"
                        :task="task" :key="task">
                    </task-item>
                </div>

                <div class="d-flex justify-content-center mt-3 task-footer">
                    <a @click="addTask">
                        + Add New
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="tasks">
                <div class="task-header">
                    <h6>To do</h6>
                </div>
                <div class="tasks-body p-0">
                    <task-item v-for="(task, index) in tasks" @remove="removeTask(index)" @complete="completeTask(task)"
                        :task="task" :key="task">
                    </task-item>
                </div>

                <div class="d-flex justify-content-center mt-3 task-footer">
                    <a @click="addTask">
                        + Add New
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import TaskItem from '../components/TaskItem.vue';
export default {
    name: "Home",
    components: { TaskItem },
    data() {
        return {
            newTask: '',
            tasks: [
                {
                    title: 'https://prnt.sc/tu66bK1ftNTI product collection from navbar is not active when we are in add or edit collection page',
                    completed: true
                },
                {
                    title: 'Go skydiving',
                    completed: false
                }
            ]
        };
    },
    computed: {
        incomplete() {
            return this.tasks.filter(this.inProgress).length;
        }
    },
    methods: {
        addTask() {
            if (this.newTask) {
                this.tasks.push({
                    title: this.newTask,
                    completed: false
                });
                this.newTask = '';
            }
        },
        completeTask(task) {
            task.completed = !task.completed;
        },
        removeTask(index) {
            this.tasks.splice(index, 1);
        },
        clearCompleted() {
            this.tasks = this.tasks.filter(this.inProgress);
        },
        clearAll() {
            this.tasks = [];
        },

        inProgress(task) {
            return !this.isCompleted(task);
        },
        isCompleted(task) {
            return task.completed;
        }
    }

}
</script>