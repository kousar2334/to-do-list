<template>
    <div class="row">
        <div class="col-12 mt-3">
            <button class="btn btn-success rounded" @click="data.newListModalShow = !data.newListModalShow"
                v-if="data.lists.length > 0">
                Add New List
            </button>
        </div>
        <!--To do list-->
        <div v-if="data.lists.length > 0 && !data.dataLoading" class="col-lg-3" v-for="(list, listIndex) in data.lists">
            <list :list="list" :index="listIndex" @show-list-edit-modal="editList" @delete-list="deleteList"></list>
        </div>

        <!--End to do list-->
        <div class="col-6 d-flex flex-column justify-content-center mt-5 mx-auto"
            v-if="data.lists.length < 1 && !data.dataLoading">
            <p class="alert alert-danger">No List found</p>
            <button class="btn btn-success rounded" @click="data.newListModalShow = !data.newListModalShow">
                Create First List
            </button>
        </div>

        <b-pagination v-if="data.lists.length > 0 && !data.dataLoading" :value="data.currentPage" v-model="data.currentPage"
            :total-rows="data.totalItems" :per-page="data.perPage" @page-click="pagination" pills align="center"
            class="mt-5">
        </b-pagination>


        <!--New List modal-->
        <b-modal v-model="data.newListModalShow" title="Create New List" hide-footer>
            <b-container fluid>
                <div class="form-group pb-3">
                    <label class="mb-2">List Name</label>
                    <input type="text" placeholder="Name" class="form-control" v-model="data.newList">
                    <template v-if="data.errors.name">
                        <p class="fz-12 text-danger mt-1 mb-0" v-for="(error, index) in data.errors.name" :key="index">
                            {{ error }}
                        </p>
                    </template>
                </div>
                <div class="m-0 row">
                    <button class="btn btn-primary" :class="{ loading: data.submit_data }"
                        @click.prevent="storeNewList">Save</button>
                </div>
            </b-container>
        </b-modal>
        <!--End new list modal-->

        <!--Edit modal-->
        <b-modal v-model="data.listEditModalShow" title="Update List" hide-footer>
            <b-container fluid>
                <div class="form-group pb-3">
                    <label class="mb-2">List Name</label>
                    <input type="text" placeholder="Name" class="form-control" v-model="data.editList.name">
                    <template v-if="data.errors.name">
                        <p class="fz-12 text-danger mt-1 mb-0" v-for="(error, index) in data.errors.name" :key="index">
                            {{ error }}
                        </p>
                    </template>
                </div>
                <div class="m-0 row">
                    <button class="btn btn-primary" :class="{ loading: data.submit_data }" @click.prevent="updateList">
                        Save Change
                    </button>
                </div>
            </b-container>
        </b-modal>
        <!--End Edit modal-->
    </div>
</template>
<script>
import axios from "axios";
import { defineComponent, reactive } from "vue";
import { useToast } from "vue-toastification";
import List from "../components/List.vue"
import { useStore } from 'vuex';
import { onMounted } from "vue";
export default defineComponent({
    name: "Home",
    components: { List },
    setup() {
        const data = reactive({
            errors: [],
            submit_data: false,
            newList: "",
            editList: {},
            lists: [],
            newListModalShow: false,
            listEditModalShow: false,
            dataLoading: true,
            currentPage: 1,
            perPage: 4,
            totalItems: 10,
        });
        const toast = useToast();
        const store = useStore();
        const config = {
            headers: {
                Authorization: `Bearer ${store.getters.userToken}`,
            },
        }

        onMounted(() => {
            getLists();
        });

        function storeNewList() {
            data.submit_data = true;
            data.errors = [];
            axios.post('api/v1/store-list', {
                name: data.newList,
            }, config).then((response) => {
                if (response.data.success) {
                    data.newListModalShow = false;
                    data.newList = "";
                    toast.success("New list created successfully");
                    data.currentPage = 1;
                    data.lists = [];
                    getLists();
                }
                if (!response.data.success) {
                    toast.error("List create failed");
                }
                data.submit_data = false;
            }).catch((error) => {
                data.submit_data = false;
                if (error.response.status == 422) {
                    data.errors = error.response.data.errors;
                }
                if (!error.response.status == 422) {
                    toast.error("List create failed");
                }

            });
        }

        function getLists() {
            data.dataLoading = true;
            axios.post('api/v1/get-to-do-lists', {
                page: data.currentPage,
            }, config).then((response) => {
                if (response.data.success) {
                    data.lists = response.data.data;
                    data.currentPage = response.data.meta.current_page;
                    data.totalItems = response.data.meta.total
                }
                if (!response.data.success) {
                    toast.error("Data Loading failed");
                }
                data.dataLoading = false;
            }).catch((error) => {
                data.dataLoading = false;
                toast.error("Data Loading failed");
            });
        }

        function editList(list) {
            data.editList = list;
            data.listEditModalShow = true;
        }

        function updateList() {
            data.submit_data = true;
            data.errors = [];
            axios.post('api/v1/update-list', {
                name: data.editList.name,
                id: data.editList.id
            }, config).then((response) => {
                if (response.data.success) {
                    data.listEditModalShow = false;
                    toast.success("List update successfully");
                    data.editList = {};
                    data.lists = [];
                    getLists();
                }
                if (!response.data.success) {
                    toast.error("List update failed");
                }
                data.submit_data = false;
            }).catch((error) => {
                data.submit_data = false;
                if (error.response.status == 422) {
                    data.errors = error.response.data.errors;
                }
                if (!error.response.status == 422) {
                    toast.error("List update failed");
                }

            });
        }

        function deleteList(id) {
            axios.post('api/v1/delete-list', {
                id: id
            }, config).then((response) => {
                if (response.data.success) {
                    toast.success("List deleted successfully");
                    data.lists = [];
                    getLists();
                }
                if (!response.data.success) {
                    toast.error("List delete failed");
                }
            }).catch((error) => {
                toast.error("List delete failed");
            });
        }

        function pagination(event, page) {
            data.currentPage = page;
            getLists();
        }

        return {
            data,
            storeNewList,
            getLists,
            updateList,
            editList,
            deleteList,
            pagination
        };
    },

})
</script>