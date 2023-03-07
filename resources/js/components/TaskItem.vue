<template>
    <div class="tasks__item tasks__item__toggle">
        <div class="content">
            <p>
                {{ task.name }}
            </p>
        </div>
        <div class="action-area d-flex justify-content-between">
            <p class="mb-0">{{ task.date }}</p>
            <div class="action-btn d-flex gap-2">
                <button class="p-0 border-0 text-secondary fs-6"
                    :class="{ completed: task.status == 1, incomplete: task.status == 0 }" title="Make incomplete">
                    <font-awesome-icon icon="fas fa-check" />
                </button>
                <button class="task-edit-btn p-0 border-0 text-secondary fs-6" @click="$emit('remove')">
                    <font-awesome-icon icon="fas fa-pencil" />
                </button>
                <button class="task-remove-btn p-0 border-0 text-danger" @click="removeTask()">
                    <font-awesome-icon icon="fas fa-trash-alt" />
                </button>

            </div>
        </div>
    </div>
</template>
<script>
import axios from "axios";
import { defineComponent, reactive } from "vue";
import { useToast } from "vue-toastification";
import { useStore } from 'vuex';
export default defineComponent({
    name: "TaskItem",
    props: {
        task: {
            type: Object,
            required: true,
        }
    },
    setup(props) {
        const data = reactive({
            errors: [],
            submit_data: false,
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

        function removeTask() {
            axios.post('api/v1/delete-task', {
                id: props.task.id,
            }, config).then((response) => {
                if (response.data.success) {
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
            removeTask,
        };
    },

})
</script>