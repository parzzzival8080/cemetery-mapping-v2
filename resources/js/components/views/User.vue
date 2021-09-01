<template>
    <v-container fluid>
        <v-data-table
            :loading="tableLoading"
            loading-text="Fetching subscriber list... Please wait"
            :headers="tableSubscriberHeaders"
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
                        <v-icon small left>mdi-plus-circle</v-icon> Add
                        Subscriber
                    </v-btn>
                </v-toolbar>
            </template>
            <template v-slot:item.name="{ item }">
                {{ item.first_name }} {{ item.last_name }}
            </template>

            <template v-slot:item.plan="{ item }">
                <v-edit-dialog
                    :return-value.sync="editedSubscriberInformation.plan_id"
                    large
                    persistent
                    @save="updateSubscriberPlan()"
                    @open="openPlanDialog(item)"
                >
                    <template v-slot:input>
                        <div class="mt-4 text-h6">
                            Update Plan
                        </div>
                        <v-select
                            :items="plans"
                            item-value="id"
                            item-text="name"
                            v-model="editedSubscriberInformation.plan_id"
                            :rules="rules.required"
                            label="Edit"
                            single-line
                            autofocus
                        ></v-select>
                    </template>
                    {{ item.subscriber_plan.plan.name }}
                </v-edit-dialog>
            </template>

            <template v-slot:item.sender_name="{ item }">
                <v-edit-dialog
                    :return-value.sync="editedSubscriberInformation.sender_id"
                    large
                    persistent
                    @save="updateSubscriberPlan()"
                    @open="openPlanDialog(item)"
                >
                    <template v-slot:input>
                        <div class="mt-4 text-h6">
                            Update Sender Name
                        </div>
                        <v-text-field
                            v-model="editedSubscriberInformation.sender_id"
                            :rules="rules.required"
                            label="Sender Name"
                            autofocus
                        ></v-text-field>
                    </template>
                    {{ item.subscriber_plan.sender_id }}
                </v-edit-dialog>
            </template>

            <template v-slot:item.sender_key="{ item }">
                <v-edit-dialog
                    :return-value.sync="
                        editedSubscriberInformation.sender_id_api_key
                    "
                    large
                    persistent
                    @save="updateSubscriberPlan()"
                    @open="openPlanDialog(item)"
                >
                    <template v-slot:input>
                        <div class="mt-4 text-h6">
                            Update Key
                        </div>
                        <v-text-field
                            v-model="
                                editedSubscriberInformation.sender_id_api_key
                            "
                            :rules="rules.required"
                            label="Api Key"
                            autofocus
                        ></v-text-field>
                    </template>
                    {{ item.subscriber_plan.sender_id_api_key }}
                </v-edit-dialog>
            </template>

            <template v-slot:item.status="{ item }">
                <v-edit-dialog
                    :return-value.sync="editedSubscriberInformation.is_active"
                    large
                    persistent
                    @save="updateSubscriber()"
                    @open="openStatusDialog(item)"
                >
                    <template v-slot:input>
                        <div class="mt-4 text-h6">
                            Update Status
                        </div>
                        <v-select
                            :items="statuses"
                            item-value="value"
                            item-text="text"
                            v-model="editedSubscriberInformation.is_active"
                            :rules="rules.required"
                            label="Edit"
                            single-line
                            autofocus
                        ></v-select>
                    </template>
                    <v-chip
                        v-if="item.is_active"
                        class="white--text"
                        color="success"
                    >
                        ACTIVE
                    </v-chip>
                    <v-chip v-else class="white--text" color="error">
                        INACTIVE
                    </v-chip>
                </v-edit-dialog>
            </template>

            <!-- <template v-slot:item.actions="{ item }">
                <v-btn icon>
                    <v-icon>mdi-information</v-icon>
                </v-btn>
            </template> -->
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
                                    v-model="
                                        editedSubscriberInformation.first_name
                                    "
                                    :error-messages="formErrors.first_name"
                                    :rules="rules.required"
                                    label="First Name"
                                ></v-text-field
                            ></v-col>
                            <v-col cols="12" md="6"
                                ><v-text-field
                                    v-model="
                                        editedSubscriberInformation.last_name
                                    "
                                    :error-messages="formErrors.last_name"
                                    :rules="rules.required"
                                    label="Last Name"
                                ></v-text-field
                            ></v-col>
                        </v-row>
                        <v-row justify="center">
                            <v-col cols="12" md="6"
                                ><v-text-field
                                    v-model="
                                        editedSubscriberInformation.phone_number
                                    "
                                    :error-messages="formErrors.phone_number"
                                    :rules="rules.contactRules"
                                    maxlength="11"
                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                    label="Contact Number"
                                ></v-text-field
                            ></v-col>
                            <v-col cols="12" md="6"
                                ><v-text-field
                                    v-model="
                                        editedSubscriberInformation.user.email
                                    "
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
                                    v-model="
                                        editedSubscriberInformation.plan_id
                                    "
                                    :rules="rules.required"
                                    label="Plan"
                                ></v-select
                            ></v-col>
                            <v-col cols="12" md="6"
                                ><v-select
                                    :items="roles"
                                    v-model="editedSubscriberInformation.role"
                                    :rules="rules.required"
                                    label="Role"
                                ></v-select
                            ></v-col>
                        </v-row>
                        <v-row justify="center">
                            <v-col cols="12" md="6"
                                ><v-text-field
                                    v-model="
                                        editedSubscriberInformation.affiliation
                                    "
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
                                    v-model="
                                        editedSubscriberInformation.position
                                    "
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
                                        editedSubscriberInformation.referral_code
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
                                        editedSubscriberInformation.user
                                            .password
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
                    <v-btn class="px-12" @click="saveSubscriber" color="primary"
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
            tableSubscriberHeaders: [
                { text: "ID", value: "id" },
                { text: "Name", value: "name" },
                { text: "Contact Number", value: "phone_number" },
                { text: "Email", value: "user.email" },
                { text: "Plan", value: "plan" },
                { text: "Sender Name", value: "sender_name" },
                { text: "Api Key", value: "sender_key" },
                { text: "Status", value: "status" }
                // {
                //     text: "Actions",
                //     value: "actions",
                //     sortable: false,
                //     align: "center"
                // }
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
            defaultSubscriberInformation: {
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

            editedSubscriberInformation: {
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
            return this.editedIndex === -1
                ? "New Subscriber"
                : "Edit Subscriber";
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

        saveSubscriber() {
            this.formOverlay = true;
            if (this.$refs.subscriberForm.validate()) {
                this.componentOverlay = true;
                if (this.editedContactIndex > -1) {
                    this.updateSubscriber();
                } else {
                    this.createSubscriber();
                }
            }
        },

        createSubscriber() {
            axios
                .post("/api/v1/subscribers", {
                    ..._.omit(this.editedSubscriberInformation, "user"),
                    ...this.editedSubscriberInformation.user,
                    password_confirmation: this.editedSubscriberInformation.user
                        .password,
                    phone_number: this.editedSubscriberInformation.phone_number
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

        editSubscriber(subsciber) {
            this.editedIndex = this.tableSubsriber.indexOf(subsciber);
            this.editedSubscriberInformation = Object.assign({}, subsciber);
            if (!this.editedSubscriberInformation.user)
                this.editedSubscriberInformation.user = {
                    email: null,
                    password: null
                };
            this.formDialog = true;
        },

        updateSubscriber() {
            axios
                .put(
                    "/api/v1/subscribers/" +
                        this.editedSubscriberInformation.id,
                    {
                        ..._.omit(
                            this.editedSubscriberInformation,
                            "user",
                            "subscriber_plan"
                        ),
                        ...this.editedSubscriberInformation.user,
                        password_confirmation: this.editedSubscriberInformation
                            .user.password,
                        phone_number: this.editedSubscriberInformation
                            .phone_number
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

        deleteSubscriber(subsciber) {
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
                this.editedSubscriberInformation = Object.assign(
                    {},
                    this.defaultSubscriberInformation
                );
                this.editedIndex = -1;
            }, 500);
        },

        updateSubscriberPlan() {
            axios
                .put(
                    "/api/v1/subscriber-plans/" +
                        this.editedSubscriberInformation.subscriber_plan.id,
                    {
                        plan_id: this.editedSubscriberInformation.plan_id,
                        sender_id: this.editedSubscriberInformation.sender_id,
                        sender_id_api_key: this.editedSubscriberInformation
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
            this.editedSubscriberInformation = Object.assign({
                ...this.editedSubscriberInformation,
                ...item
            });
        },

        openPlanDialog(item) {
            this.editedSubscriberInformation = Object.assign({
                ...this.editedSubscriberInformation,
                ...item,
                plan_id: item.subscriber_plan.plan.id,
                sender_id: item.subscriber_plan.sender_id,
                sender_id_api_key: item.subscriber_plan.sender_id_api_key
            });
        }
    }
};
</script>
