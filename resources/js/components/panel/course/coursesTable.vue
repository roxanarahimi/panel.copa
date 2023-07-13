<template>
    <div v-if="allData" class="card">
        <div class="card-body table-responsive">
            <table class = "table">
                <thead>
                <tr>
                    <th scope = "col"></th>
                    <!--                                    <th class = "d-none d-md-table-cell" style = "width: 100px" scope = "col">تصویر</th>-->
                    <th scope = "col">عنوان</th>
                    <th scope = "col">دسته</th>
                    <th scope = "col">قیمت</th>
                    <th scope = "col">%تخفیف</th>
                    <th class = "d-none d-xl-table-cell" scope = "col">ظرفیت</th>
                    <th class = "d-none d-xl-table-cell" scope = "col">متن</th>
                    <th class = "d-none d-md-table-cell" scope = "col">تاریخ شروع</th>
                    <th class = "d-none d-md-table-cell" scope = "col">تاریخ پایان</th>
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
                        <router-link :to = "'/panel/course/'+data.id">{{ data.title }}</router-link>
                    </td>

                    <td :title = "!data.category.active? 'دسته غیر فعال است': ''" :class = "{'text-decoration-line-through text-muted ': !data.category.active}">
                        {{ data.category.title }}
                    </td>

                    <td>{{ data.price }}</td>
                    <td>{{ data.off }}</td>
                    <td>{{ data.capacity }}</td>
                    <td>{{ data.description }}</td>

                    <td class = "d-none d-xl-table-cell">{{ data.start }}</td>
                    <td class = "d-none d-xl-table-cell text_cell">{{ data.end }}</td>
                    <td class = "d-none d-md-table-cell date_cell">{{ data.created_at }}</td>
                    <td class = "active_cell">
                        <span @click="activeToggle(model,data.id)" v-if="data.active" class="badge bg-success text-light"><i class="bi bi-eye-fill"></i></span>
                        <span @click="activeToggle(model,data.id)" v-else class="badge bg-danger text-light"><i class="bi bi-eye-slash-fill"></i></span>
                    </td>
                    <td>
                        <span role = "button" data-bs-toggle = "dropdown" aria-expanded = "false"><i class = "bi bi-three-dots-vertical"></i></span>
                        <ul class = "dropdown-menu" aria-labelledby = "navbarScrollingDropdown">
                            <li>
                                <router-link :to = "'/panel/course/'+data.id" class = "dropdown-item" style = "text-align: right !important">
                                    مشاهده
                                </router-link>
                                <router-link :to = "'/panel/edit/course/'+data.id" class = "dropdown-item" style = "text-align: right !important">
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
    name: "coursesTable",
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
