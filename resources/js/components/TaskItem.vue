<template>
    <div class="tasks__item tasks__item__toggle">
        <div class="content">
            <p>
                {{ task.name }}
            </p>
        </div>
        <div class="action-area d-flex justify-content-between">
            <p class="mb-0 small text-secondary">{{ task.date }}</p>
            <div class="action-btn d-flex gap-2">
                <button class="task-action-btn" :class="{ done: task.status == 1, pending: task.status == 0 }"
                    title="Change Status" @click="changeStatus">
                    <font-awesome-icon icon="fas fa-check" />
                </button>
                <button class="task-action-btn" @click="editTask" title="Edit Task">
                    <font-awesome-icon icon="fas fa-pencil" />
                </button>
                <button class="task-action-btn danger" @click="deleteTask" title="Delete Task">
                    <font-awesome-icon icon="fas fa-trash-alt" />
                </button>

            </div>
        </div>
    </div>
</template>
<script>
import { defineComponent } from "vue";
export default defineComponent({
    name: "TaskItem",
    props: {
        task: {
            type: Object,
            required: true,
        }
    },
    setup(props, { emit }) {

        function deleteTask() {
            emit('deleteTask', props.task.id);
        }

        function editTask() {
            emit('editTask', props.task);
        }
        function changeStatus() {
            emit('changeStatus', props.task.id);
        }

        return {
            deleteTask,
            editTask,
            changeStatus
        };
    },

})
</script>