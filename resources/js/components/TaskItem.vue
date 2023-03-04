<template>
    <div class="tasks__item tasks__item__toggle">
        <div class="content">
            <p>
                {{ task.title }}
            </p>
        </div>
        <div class="action-area d-flex justify-content-between">
            <p class="mb-0">Jun 5</p>
            <div class="action-btn d-flex gap-2">
                <button class="p-0 border-0 text-secondary fs-6" :class="className" title="Make incomplete">
                    <font-awesome-icon icon="fas fa-check" />
                </button>
                <button class="task-edit-btn p-0 border-0 text-secondary fs-6" @click="$emit('remove')">
                    <font-awesome-icon icon="fas fa-pencil" />
                </button>
                <button class="task-remove-btn p-0 border-0 text-danger" @click="$emit('remove')">
                    <font-awesome-icon icon="fas fa-trash-alt" />
                </button>

            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "TaskItem",
    props: ['task'],
    computed: {
        className() {
            let classes = ['incomplete'];
            if (this.task.completed) {
                classes.push('completed');
            }
            return classes.join(' ');
        }
    }
}
</script>