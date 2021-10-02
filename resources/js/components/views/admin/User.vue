<template>
    <v-container fluid>
        <v-data-table
            :loading="tableLoading"
            loading-text="Fetching subscriber list... Please wait"
            :headers="tableUserHeaders"
            :items="tableSubsriber"
            :search="tableSearch"
        >
            <template v-slot:top>
                <v-toolbar flat>
                    <v-toolbar-title class="headline"
                        >Subsriber</v-toolbar-title
                    >
                    <div class="flex-grow-1"></div>
                    <v-btn small color="primary" @click="formDialog = true">
                        <v-icon small left>mdi-plus-circle</v-icon> Add User
                    </v-btn>
                </v-toolbar>
            </template>

            <template v-slot:item.actions="{ item }">
                <v-btn icon>
                    <v-icon>mdi-information</v-icon>
                </v-btn>
            </template>
        </v-data-table>
        <v-dialog v-model="formDialog" max-width="500px" persistent>
            <template v-slot:activator="{ on }"> </template>
            <v-card>
                <v-overlay :value="formOverlay">
                    <v-progress-circular
                        :size="100"
                        :width="5"
                        indeterminate
                    ></v-progress-circular>
                </v-overlay>
                <v-card-title class="headline">
                    {{ formTitle }}
                </v-card-title>
                <v-card-text>
                    <v-form ref="subscriberForm" lazy-validation>
                        <v-row justify="center">
                            <v-col cols="12" md="6"
                                ><v-text-field
                                    v-model="editedUserInformation.first_name"
                                    :error-messages="formErrors.first_name"
                                    :rules="rules.required"
                                    label="First Name"
                                ></v-text-field
                            ></v-col>
                            <v-col cols="12" md="6"
                                ><v-text-field
                                    v-model="editedUserInformation.last_name"
                                    :error-messages="formErrors.last_name"
                                    :rules="rules.required"
                                    label="Last Name"
                                ></v-text-field
                            ></v-col>
                        </v-row>
                        <v-row justify="center">
                            <v-col cols="12" md="6"
                                ><v-text-field
                                    v-model="editedUserInformation.phone_number"
                                    :error-messages="formErrors.phone_number"
                                    :rules="rules.contactRules"
                                    maxlength="11"
                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                    label="Contact Number"
                                ></v-text-field
                            ></v-col>
                            <v-col cols="12" md="6"
                                ><v-text-field
                                    v-model="editedUserInformation.user.email"
                                    :error-messages="formErrors.email"
                                    :rules="rules.emailRules"
                                    label="Email"
                                ></v-text-field
                            ></v-col>
                        </v-row>
                        <v-row justify="center">
                            <v-col cols="12" md="6"
                                ><v-select
                                    :items="plans"
                                    item-value="id"
                                    item-text="name"
                                    v-model="editedUserInformation.plan_id"
                                    :rules="rules.required"
                                    label="Plan"
                                ></v-select
                            ></v-col>
                            <v-col cols="12" md="6"
                                ><v-select
                                    :items="roles"
                                    v-model="editedUserInformation.role"
                                    :rules="rules.required"
                                    label="Role"
                                ></v-select
                            ></v-col>
                        </v-row>
                        <v-row justify="center">
                            <v-col cols="12" md="6"
                                ><v-text-field
                                    v-model="editedUserInformation.affiliation"
                                    ><template v-slot:label>
                                        <div>
                                            Business Name/Organization
                                            <small>(Optional)</small>
                                        </div>
                                    </template>
                                </v-text-field></v-col
                            >
                            <v-col cols="12" md="6"
                                ><v-text-field
                                    v-model="editedUserInformation.position"
                                    ><template v-slot:label>
                                        <div>
                                            Position
                                            <small>(Optional)</small>
                                        </div>
                                    </template>
                                </v-text-field></v-col
                            >
                        </v-row>
                        <v-row justify="center">
                            <v-col cols="12"
                                ><v-text-field
                                    v-model="
                                        editedUserInformation.referral_code
                                    "
                                    :error-messages="formErrors.referral_code"
                                    ><template v-slot:label>
                                        <div>
                                            Referral Code
                                            <small>(Optional)</small>
                                        </div>
                                    </template></v-text-field
                                ></v-col
                            >
                        </v-row>
                        <v-row justify="center">
                            <v-col cols="12"
                                ><v-text-field
                                    v-model="
                                        editedUserInformation.user.password
                                    "
                                    label="Password"
                                    id="password"
                                    name="password"
                                    :append-icon="
                                        visible ? 'mdi-eye-off' : 'mdi-eye'
                                    "
                                    @click:append="visible = !visible"
                                    :rules="rules.passwordRules"
                                    :type="visible ? 'text' : 'password'"
                                    @keydown.enter="register()"
                                ></v-text-field
                            ></v-col>
                        </v-row>
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn class="px-12" text @click="closeForm">Cancel</v-btn>
                    <v-btn class="px-12" @click="saveUser" color="primary"
                        >Save</v-btn
                    >
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            deleteDialog: false,
            formDialog: false,
            formOverlay: false,
            formErrors: {
                first_name: null,
                last_name: null,
                phone_number: null,
                email: null,
                password: null
            },
            visible: false,
            tableLoading: true,
            tableUserHeaders: [
                { text: "ID", value: "id" },
                { text: "Name", value: "name" },
                { text: "Contact Number", value: "phone_number" },
                {
                    text: "Actions",
                    value: "actions",
                    sortable: false,
                    align: "center"
                }
            ],
            tableSubsriber: [],
            tableSearch: null,
            statuses: [
                { value: 1, text: "ACTIVE" },
                { value: 0, text: "INACTIVE" }
            ],
            plans: [],
            roles: ["SUBSCRIBER", "PARTNER"],
            editedIndex: -1,
            defaultUserInformation: {
                first_name: null,
                last_name: null,
                phone_number: null,
                user: { email: null, password: null },
                is_active: true,
                plan_id: null,
                role: "SUBSCRIBER",
                affiliation: null,
                position: null
            },

            editedUserInformation: {
                first_name: null,
                last_name: null,
                phone_number: null,
                user: { email: null, password: null },
                is_active: true,
                plan_id: null,
                role: "SUBSCRIBER",
                affiliation: null,
                position: null
            },

            rules: {
                required: [v => !!v || "Field is required"],
                emailRules: [
                    v => !!v || "E-mail is required",
                    v =>
                        /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) ||
                        "E-mail must be valid",
                    v =>
                        (!!v && v.length <= 255) ||
                        "E-mail must not be more than 255 characters"
                ],
                contactRules: [
                    v => !!v || "Contact Number is required",
                    v =>
                        (!!v && v.length >= 10) ||
                        "Contact Number must be 11 characters",
                    v =>
                        (!!v && v.length < 11) ||
                        "Contact Number must not be more than 11 characters"
                ],
                subsciberRules: [
                    v => !!v || "Contact Number is required",
                    v =>
                        (!!v && v.length >= 10) ||
                        "Contact Number must be 11 characters",
                    v =>
                        (!!v && v.length < 11) ||
                        "Contact Number must not be more than 11 characters"
                ],
                passwordRules: [
                    v => !!v || "Password is required",
                    v =>
                        (!!v && v.length >= 8) ||
                        "Password must be more than 8 characters"
                ]
            }
        };
    },

    computed: {
        formTitle() {
            return this.editedIndex === -1 ? "New User" : "Edit User";
        }
    },

    mounted() {
        this.fetchSubsribers();
        this.fetchPlans();
    },

    methods: {
        fetchSubsribers() {
            this.tableLoading = true;
            axios
                .get("/api/v1/subscribers")
                .then(response => {
                    this.tableSubsriber = response.data;
                })
                .catch(error => {
                    console.log(error);
                })
                .finally(() => (this.tableLoading = false));
        },

        fetchPlans() {
            this.componentOverlay = true;
            axios
                .get("/api/v1/plans")
                .then(response => {
                    this.plans = response.data;
                })
                .catch(error => {
                    console.log(error);
                })
                .finally(() => {
                    this.componentOverlay = false;
                });
        },

        saveUser() {
            this.formOverlay = true;
            if (this.$refs.subscriberForm.validate()) {
                this.componentOverlay = true;
                if (this.editedContactIndex > -1) {
                    this.updateUser();
                } else {
                    this.createUser();
                }
            }
        },

        createUser() {
            axios
                .post("/api/v1/subscribers", {
                    ..._.omit(this.editedUserInformation, "user"),
                    ...this.editedUserInformation.user,
                    password_confirmation: this.editedUserInformation.user
                        .password,
                    phone_number: this.editedUserInformation.phone_number
                })
                .then(response => {
                    this.fetchSubsribers();
                    this.closeForm();
                })
                .catch(error => {
                    this.formOverlay = false;

                    if (error.response.status == 422) {
                        this.formErrors = error.response.data.errors;
                    } else {
                        console.log(error);
                    }
                })
                .finally(() => {});
        },

        editUser(subsciber) {
            this.editedIndex = this.tableSubsriber.indexOf(subsciber);
            this.editedUserInformation = Object.assign({}, subsciber);
            if (!this.editedUserInformation.user)
                this.editedUserInformation.user = {
                    email: null,
                    password: null
                };
            this.formDialog = true;
        },

        updateUser() {
            axios
                .put("/api/v1/subscribers/" + this.editedUserInformation.id, {
                    ..._.omit(
                        this.editedUserInformation,
                        "user",
                        "subscriber_plan"
                    ),
                    ...this.editedUserInformation.user,
                    password_confirmation: this.editedUserInformation.user
                        .password,
                    phone_number: this.editedUserInformation.phone_number
                })
                .then(response => {
                    this.fetchSubsribers();
                    this.closeForm();
                })
                .catch(error => {
                    this.formOverlay = false;

                    if (error.response.status == 422) {
                        this.formErrors = error.response.data.errors;
                    } else {
                        console.log(error);
                    }
                })
                .finally(() => {});
        },

        deleteUser(subsciber) {
            axios
                .delete("/api/v1/subscribers/" + subsciber.id)
                .then(response => {
                    this.tableSubsriber.pop(subsciber);
                })
                .catch(error => {
                    console.log(error);
                })
                .finally(() => {
                    this.closeForm();
                });
        },

        closeForm() {
            this.formDialog = false;
            this.formOverlay = false;
            this.deleteDialog = false;
            setTimeout(() => {
                this.formErrors = {
                    name: null,
                    phone_number: null,
                    address: null,
                    postal_code: null,
                    username: null,
                    password: null
                };
                this.editedUserInformation = Object.assign(
                    {},
                    this.defaultUserInformation
                );
                this.editedIndex = -1;
            }, 500);
        },

        updateUserPlan() {
            axios
                .put(
                    "/api/v1/subscriber-plans/" +
                        this.editedUserInformation.subscriber_plan.id,
                    {
                        plan_id: this.editedUserInformation.plan_id,
                        sender_id: this.editedUserInformation.sender_id,
                        sender_id_api_key: this.editedUserInformation
                            .sender_id_api_key
                    }
                )
                .then(response => {
                    this.fetchSubsribers();
                    this.closeForm();
                })
                .catch(error => {
                    this.formOverlay = false;

                    if (error.response.status == 422) {
                        this.formErrors = error.response.data.errors;
                    } else {
                        console.log(error);
                    }
                })
                .finally(() => {});
        },

        openStatusDialog(item) {
            this.editedUserInformation = Object.assign({
                ...this.editedUserInformation,
                ...item
            });
        },

        openPlanDialog(item) {
            this.editedUserInformation = Object.assign({
                ...this.editedUserInformation,
                ...item,
                plan_id: item.subscriber_plan.plan.id,
                sender_id: item.subscriber_plan.sender_id,
                sender_id_api_key: item.subscriber_plan.sender_id_api_key
            });
        }
    }
};
</script>
