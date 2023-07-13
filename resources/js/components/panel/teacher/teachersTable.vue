<template>
    <div v-if="allData" class="card">
        <div class="card-body table-responsive">
            <table class = "table">
                <thead>
                <tr>
                    <th scope = "col"></th>
                    <!--                                    <th class = "d-none d-md-table-cell" style = "width: 100px" scope = "col">تصویر</th>-->
                    <th scope = "col">نام</th>
                    <th scope = "col">جنسیت</th>
                    <th scope = "col">دوره های فعلی</th>
                    <th scope = "col">تولد</th>
                    <th class = "d-none d-md-table-cell" scope = "col">تاریخ ثبت</th>
                    <th scope = "col" class = "active_cell">وضعیت</th>
                    <th scope = "col"></th>
                </tr>
                </thead>
                <tbody>

                <tr :id = "'row_'+data.id" v-for = "(data, index) in allData" :key = "data.id" :data-index = "index">
                    <td>{{ index + 1 }}</td>
                    <!--                                    <td class = "d-none d-md-table-cell" style = "width: 100px">-->
                    <!--                                        <img v-if = "data.image" :src = "data.image" width = "80" alt = "">-->
                    <!--                                        &lt;!&ndash;       tumb&ndash;&gt;-->
                    <!--                                    </td>-->
                    <td>
                        <router-link :to = "'/panel/teacher/'+data.id">{{ data.name }}</router-link>
                    </td>
                    <td>{{ data.gender }}</td>
                    <!--        <td>{{ data.cources.count }}</td>-->
                    <td> x </td>
                    <td>{{ data.birth }}</td>

                    <td class = "d-none d-md-table-cell date_cell">{{ data.created_at }}</td>
                    <td class = "active_cell">
                        <span @click="activeToggle(model,data.id)" v-if="data.active" class="badge bg-success text-light"><i class="bi bi-eye-fill"></i></span>
                        <span @click="activeToggle(model,data.id)" v-else class="badge bg-danger text-light"><i class="bi bi-eye-slash-fill"></i></span>
                    </td>
                    <td>
                        <span role = "button" data-bs-toggle = "dropdown" aria-expanded = "false"><i class = "bi bi-three-dots-vertical"></i></span>
                        <ul class = "dropdown-menu" aria-labelledby = "navbarScrollingDropdown">
                            <li>
                                <router-link :to = "'/panel/teacher/'+data.id" class = "dropdown-item" style = "text-align: right !important">
                                    مشاهده
                                </router-link>
                                <router-link :to = "'/panel/edit/teacher/'+data.id" class = "dropdown-item" style = "text-align: right !important">
                                    ویرایش
                                </router-link>
                                <a class = "dropdown-item" @click = "showDeleteModal(data.id)" style = "text-align: right !important"
                                   data-bs-toggle = "modal" data-bs-target = "#exampleModal">حذف</a>
                            </li>
                        </ul>
                    </td>
                </tr>

                </tbody>
            </table>
        </div>
    </div>
</template>

<script>

import AllDataContainer from "../AllDataContainer";
// import AllDataInner from "../AllData";

export default {
    props: ['allData', 'page','model','loadData'],
    name: "teachersTable",
    async setup(props){
        const showDeleteModal = async (id) => {
            await AllDataContainer.setup().showDeleteModal(id);
        }
        const deleteInfo = async (model,id) => {
            await AllDataContainer.setup().deleteInfo(model,id);
            props.loadData(props.page);
        };
        const activeToggle = async (model,id) => {
            await AllDataContainer.setup().activeToggle(model,id);
            props.loadData(props.page);

        };

        return {showDeleteModal, deleteInfo, activeToggle}
    }
}
</script>

<style scoped>

</style>
