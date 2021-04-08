<template>
    <div>
        <div class="d-flex justify-content-between align-content-center mb-2">
            <div class="d-flex">
                <div>
                    <div class="d-flex align-items-center ml-4">
                        <label for="paginate" class="text-nowrap mr-2 mb-0"
                            >Per Page</label
                        >
                        <select v-model="paginate" class="form-control form-control-sm">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                        </select>
                    </div>
                </div>
                <div>
                    <div class="d-flex align-items-center ml-4">
                        <label for="paginate" class="text-nowrap mr-2 mb-0"
                            >FilterBy Class</label>
                        <select v-model="selectedClass" class="form-control form-control-sm">
                            <option value="">All Class</option>
                            <option v-for="item in classes" :key="item.id" :value="item.id">{{ item.name }}</option>
                        </select>
                    </div>
                </div>

                <div v-if="selectedClass">
                    <div class="d-flex align-items-center ml-4">
                        <label for="paginate" class="text-nowrap mr-2 mb-0"
                            >Section</label
                        >
                        <select v-model="selectedSection" class="form-control form-control-sm">
                            <option value="">Select a Section</option>
                            <option v-for="section in sections" :key="section.id" :value="section.id">{{ section.name }}</option>
                        </select>
                    </div>
                </div>

                <div>
                    <div class="dropdown ml-4">
                        <button
                            class="btn btn-secondary dropdown-toggle"
                            data-toggle="dropdown"
                        >
                            With Checked (1)
                        </button>
                        <div class="dropdown-menu">
                            <a
                                href="#"
                                class="dropdown-item"
                                type="button"
                            >
                                Delete
                            </a>

                            <a
                                href="#"
                                class="dropdown-item"
                                type="button"
                            >
                                Export
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <input v-model.lazy="search"
                    type="search"
                    class="form-control"
                    placeholder="Search by name,email,phone,or address..."
                />
            </div>
        </div>

        <div class="col-md-10 mb-2">
            <div>
                You are currently selecting all
                <strong>10</strong> items.
            </div>
            <div>
                You have selected <strong>10</strong> items, Do you want to
                Select All <strong>25</strong>?
                <a href="" class="ml-2">Select All</a>
            </div>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover">
                <tbody>
                    <tr>
                        <th><input type="checkbox" /></th>
                        <th>
                            Student's Name
                        </th>
                        <th>
                            Email
                        </th>
                        <th>
                            Address
                        </th>
                        <th>
                            Phone Number
                        </th>
                        <th>
                            Created At
                        </th>
                        <th>Class</th>
                        <th>Section</th>
                        <th>Action</th>
                    </tr>

                    <tr v-for="student in students.data" :key="student.id">
                        <td>
                            <input type="checkbox" />
                        </td>
                        <td>{{ student.name }}</td>
                        <td>{{ student.email }}</td>
                        <td>{{ student.address }}</td>
                        <td>{{ student.phone_number }}</td>
                        <td>{{ student.created_at }}</td>
                        <td>{{ student.class }}</td>
                        <td>{{ student.section }}</td>
                        <td>
                            <button class="btn btn-danger btn-sm">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row mt-4">
            <div class="col-sm-6 offset-5">
                <pagination :data="students" @pagination-change-page="getStudents"></pagination>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            students: {},
            paginate : 10,
            search : "",
            classes : {},
            selectedClass : '',
            selectedSection : '',
            sections : {},
        }
    },

    watch:{
        paginate: function(value){
            this.getStudents();
        },
        search: function(value){
            this.getStudents();
        },
        selectedClass : function(value){
            axios.get('/api/sections?class_id=' + this.selectedClass)
            .then(response => {
                this.sections = response.data.data;
            });
            this.getStudents();
        },
        selectedSection: function(value){
            this.getStudents();
        }
    },

    methods: {
        getStudents(page = 1){
            axios.get('/api/students?page='+ page
            + '&paginate=' + this.paginate
            + '&q=' + this.search
            + '&selectedClass=' + this.selectedClass
            + '&selectedSection=' + this.selectedSection
            )
            .then(response => {
                this.students = response.data;
            });
        }
    },

    mounted(){
        axios.get('/api/classes')
        .then(response => {
            console.log(response);
            this.classes = response.data.data;
        });
        this.getStudents();
    }
};
</script>
