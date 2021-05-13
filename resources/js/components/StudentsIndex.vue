<template>
    <div>
        <div class="d-flex justify-content-between align-content-center mb-2">
            <div class="d-flex">
                <div>
                    <div class="d-flex align-items-center ml-4">
                        <label for="paginate" class="text-nowrap mr-2 mb-0"
                            >Per Page</label
                        >
                        <select
                            v-model="paginate"
                            class="form-control form-control-sm"
                        >
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                        </select>
                    </div>
                </div>
                <div>
                    <div class="d-flex align-items-center ml-4">
                        <label for="paginate" class="text-nowrap mr-2 mb-0"
                            >FilterBy Class</label
                        >
                        <select
                            v-model="selectedClass"
                            class="form-control form-control-sm"
                        >
                            <option value="">All Class</option>
                            <option
                                v-for="item in classes"
                                :key="item.id"
                                :value="item.id"
                            >
                                {{ item.name }}
                            </option>
                        </select>
                    </div>
                </div>

                <div v-if="selectedClass">
                    <div class="d-flex align-items-center ml-4">
                        <label for="paginate" class="text-nowrap mr-2 mb-0"
                            >Section</label
                        >
                        <select
                            v-model="selectedSection"
                            class="form-control form-control-sm"
                        >
                            <option value="">Select a Section</option>
                            <option
                                v-for="section in sections"
                                :key="section.id"
                                :value="section.id"
                            >
                                {{ section.name }}
                            </option>
                        </select>
                    </div>
                </div>

                <div>
                    <div class="dropdown ml-4">
                        <button
                            v-if="checked.length > 0"
                            class="btn btn-secondary dropdown-toggle"
                            data-toggle="dropdown"
                        >
                            With Checked ({{ checked.length }})
                        </button>
                        <div class="dropdown-menu">
                            <a
                                href="#"
                                onclick="confirm('Are you sure you wanna delete this Record?') || event.stopImmediatePropagation()"
                                class="dropdown-item"
                                type="button"
                                @click.prevent="deleteRecords"
                            >
                                Delete
                            </a>

                            <a :href="url" class="dropdown-item" type="button">
                                Export
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <input
                    v-model.lazy="search"
                    type="search"
                    class="form-control"
                    placeholder="Search by name,email,phone,or address..."
                />
            </div>
        </div>

        <div class="col-md-10 mb-2" v-if="selectPage">
            <div v-if="selectAll || students.meta.total == checked.length">
                You are currently selecting all
                <strong>{{ checked.length }}</strong> items.
            </div>
            <div v-else>
                You have selected <strong>{{ checked.length }}</strong> items,
                Do you want to Select All
                <strong>{{ students.meta.total }}</strong
                >?
                <a @click.prevent="selectAllRecords" href="#" class="ml-2"
                    >Select All</a
                >
            </div>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover">
                <tbody>
                    <tr>
                        <th><input type="checkbox" v-model="selectPage" /></th>
                        <th>
                            <a href="#" @click.prevent="change_sort('name')"
                                >Student's Name</a
                            >
                            <span
                                v-if="
                                    sort_direction == 'desc' &&
                                        sort_field == 'name'
                                "
                                >&uarr;</span
                            >
                            <span
                                v-if="
                                    sort_direction == 'asc' &&
                                        sort_field == 'name'
                                "
                                >&darr;</span
                            >
                        </th>
                        <th>
                            <a href="#" @click.prevent="change_sort('email')"
                                >Email</a
                            >
                            <span
                                v-if="
                                    sort_direction == 'desc' &&
                                        sort_field == 'email'
                                "
                                >&uarr;</span
                            >
                            <span
                                v-if="
                                    sort_direction == 'asc' &&
                                        sort_field == 'email'
                                "
                                >&darr;</span
                            >
                        </th>
                        <th>
                            <a href="#" @click.prevent="change_sort('address')"
                                >Address</a
                            >
                            <span
                                v-if="
                                    sort_direction == 'desc' &&
                                        sort_field == 'address'
                                "
                                >&uarr;</span
                            >
                            <span
                                v-if="
                                    sort_direction == 'asc' &&
                                        sort_field == 'address'
                                "
                                >&darr;</span
                            >
                        </th>
                        <th>
                            <a
                                href="#"
                                @click.prevent="change_sort('phone_number')"
                                >Phone Number</a
                            >
                            <span
                                v-if="
                                    sort_direction == 'desc' &&
                                        sort_field == 'phone_number'
                                "
                                >&uarr;</span
                            >
                            <span
                                v-if="
                                    sort_direction == 'asc' &&
                                        sort_field == 'phone_number'
                                "
                                >&darr;</span
                            >
                        </th>
                        <th>
                            <a
                                href="#"
                                @click.prevent="change_sort('created_at')"
                                >Created At</a
                            >
                            <span
                                v-if="
                                    sort_direction == 'desc' &&
                                        sort_field == 'created_at'
                                "
                                >&uarr;</span
                            >
                            <span
                                v-if="
                                    sort_direction == 'asc' &&
                                        sort_field == 'created_at'
                                "
                                >&darr;</span
                            >
                        </th>
                        <th>Class</th>
                        <th>Section</th>
                        <th>Action</th>
                    </tr>

                    <tr
                        v-for="student in students.data"
                        :key="student.id"
                        :class="isChecked(student.id) ? 'table-primary' : ''"
                    >
                        <td>
                            <input
                                type="checkbox"
                                :value="student.id"
                                v-model="checked"
                            />
                        </td>
                        <td>{{ student.name }}</td>
                        <td>{{ student.email }}</td>
                        <td>{{ student.address }}</td>
                        <td>{{ student.phone_number }}</td>
                        <td>{{ student.created_at }}</td>
                        <td>{{ student.class }}</td>
                        <td>{{ student.section }}</td>
                        <td>
                            <button
                                onclick="confirm('Are you sure you wanna delete this Record?') || event.stopImmediatePropagation()"
                                class="btn btn-danger btn-sm"
                                @click="deleteSingleRecord(student.id)"
                            >
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row mt-4">
            <div class="col-sm-6 offset-5">
                <pagination
                    :data="students"
                    @pagination-change-page="getStudents"
                ></pagination>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            students: {},
            paginate: 10,
            search: "",
            classes: {},
            selectedClass: "",
            selectedSection: "",
            sections: {},
            checked: [],
            selectPage: false,
            selectAll: false,
            sort_direction: "desc",
            sort_field: "created_at",
            url: "",
            getStudentsUrl: "",
            getStudentsUrlWithoutPaginate: ""
        };
    },

    watch: {
        paginate: function(value) {
            this.getStudents();
        },
        search: function(value) {
            this.getStudents();
        },
        selectedClass: function(value) {
            this.selectedSection = "";
            axios
                .get("/api/sections?class_id=" + this.selectedClass)
                .then(response => {
                    this.sections = response.data.data;
                });
            this.getStudents();
        },
        selectedSection: function(value) {
            this.getStudents();
        },
        selectPage: function(value) {
            this.checked = [];
            if (value) {
                this.students.data.forEach(student => {
                    this.checked.push(student.id);
                });
            } else {
                this.checked = [];
                this.selectAll = false;
            }
        },
        checked: function(value) {
            this.url = "/api/students/export/" + this.checked;
        }
    },

    methods: {
        selectAllRecords() {
            axios.get(this.getStudentsUrlWithoutPaginate).then(response => {
                // console.log(response.data);
                this.checked = [];
                response.data.data.forEach(student => {
                    this.checked.push(student.id);
                });
                this.selectAll = true;
            });
        },
        change_sort(field) {
            if (this.sort_field == field) {
                this.sort_direction =
                    this.sort_direction == "asc" ? "desc" : "asc";
            } else {
                this.sort_field = field;
            }
            this.getStudents();
        },
        deleteSingleRecord(student_id) {
            axios.delete("/api/student/delete/" + student_id).then(response => {
                this.checked = this.checked.filter(id => id != student_id);
                this.$toast.success("Student Deleted Successfully");
                this.getStudents();
            });
        },
        deleteRecords() {
            axios
                .delete("/api/students/massDestroy/" + this.checked)
                .then(response => {
                    if (response.status == 204) {
                        this.$toast.success(
                            "Selected Students were Deleted Successfully"
                        );
                        this.checked = [];
                        this.getStudents();
                    }
                });
        },
        isChecked(student_id) {
            return this.checked.includes(student_id);
        },
        getStudents(page = 1) {
            this.getStudentsUrlWithoutPaginate =
                "/api/students?" +
                "q=" +
                this.search +
                "&sort_direction=" +
                this.sort_direction +
                "&sort_field=" +
                this.sort_field +
                "&selectedClass=" +
                this.selectedClass +
                "&selectedSection=" +
                this.selectedSection;

            this.getStudentsUrl = this.getStudentsUrlWithoutPaginate.concat(
                "&paginate=" + this.paginate + "&page=" + page
            );
            axios.get(this.getStudentsUrl).then(response => {
                this.students = response.data;
            });
        }
    },

    mounted() {
        axios.get("/api/classes").then(response => {
            this.classes = response.data.data;
        });
        this.getStudents();
    }
};
</script>
