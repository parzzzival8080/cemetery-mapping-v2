<template>
    <v-container fill-height fluid grid-list-xl>
        <v-overlay :value="componentOverlay">
            <v-progress-circular
                :size="100"
                :width="5"
                indeterminate
            ></v-progress-circular>
        </v-overlay>
        <v-row justify="center" wrap align="center">
            <v-col cols="12" md="10">
                <v-card class="elevation-9 ma-4">
                    <v-container>
                        <v-data-table
                            :loading="tableLoading"
                            loading-text="Fetching histories list... Please wait"
                            :headers="tableHistoryHeaders"
                            :items="histories"
                            :search="tableSearch"
                        >
                            <template v-slot:top>
                                <v-toolbar flat>
                                    <v-toolbar-title class="headline"
                                        >Purchase Histories</v-toolbar-title
                                    >
                                    <div class="flex-grow-1"></div>
                                    <v-btn
                                        small
                                        @click="formCreditDialog = true"
                                        color="primary"
                                    >
                                        <v-icon small left
                                            >mdi-cart-variant</v-icon
                                        >
                                        Buy Credit
                                    </v-btn>
                                </v-toolbar>
                            </template>
                            <template v-slot:item.id="{ item }">
                                {{
                                    histories
                                        .map(function(x) {
                                            return x.id;
                                        })
                                        .indexOf(item.id) + 1
                                }}
                            </template>
                            <template v-slot:item.amount="{ item }">
                                ₱
                                {{ formattedAmount(item.amount) }}
                            </template>
                            <template v-slot:item.status="{ item }">
                                <v-chip
                                    class="white--text"
                                    :color="statusColor(item.status)"
                                >
                                    {{ item.status }}
                                </v-chip>
                            </template>
                        </v-data-table>
                    </v-container>
                </v-card>
            </v-col>
        </v-row>
        <v-dialog v-model="formCreditDialog" max-width="500px" persistent>
            <v-form ref="creditForm" lazy-validation>
                <v-card>
                    <v-toolbar elevation="0" color="success">
                        <v-spacer></v-spacer>
                        <v-card-title class="headline white--text">
                            Buy Credit
                        </v-card-title>
                        <v-spacer></v-spacer>
                    </v-toolbar>
                    <v-card-text>
                        <v-row justify="center">
                            <v-col cols="12" md="6">
                                <v-select
                                    type="number"
                                    v-model="credit"
                                    :items="selections"
                                    label="Please Select Amount"
                                    :rules="rules.required"
                                />
                            </v-col>
                        </v-row>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            class="px-12"
                            text
                            @click="formCreditDialog = false"
                            >Cancel</v-btn
                        >
                        <v-btn
                            class="px-12"
                            @click="buyCredit()"
                            color="primary"
                            >Buy</v-btn
                        >
                    </v-card-actions>
                </v-card>
            </v-form>
        </v-dialog>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            //Table Variables
            tableHistoryHeaders: [
                {
                    text: "Id",
                    value: "id",
                    class: "table-header"
                },
                {
                    text: "Code",
                    value: "reference_code",
                    class: "table-header"
                },
                {
                    text: "Amount",
                    value: "amount",
                    class: "table-header"
                },
                {
                    text: "Status",
                    value: "status",
                    class: "table-header"
                }
            ],
            tableLoading: false,
            tableSearch: null,
            componentOverlay: false,
            histories: [],
            selections: [500, 1000, 2500, 5000, 10000],
            credit: 0,
            profileId: sessionStorage.getItem("profile-id"),
            rules: {
                //Form Field Rules
                required: [v => !!v || "Field is required"]
            },

            formCreditDialog: false
        };
    },

    mounted() {
        this.fetchHistories();
    },

    methods: {
        fetchHistories() {
            this.tableLoading = true;
            axios
                .get(
                    "/api/v1/subscribers/" +
                        this.profileId +
                        "/purchase-histories"
                )
                .then(response => {
                    this.histories = response.data;
                })
                .catch(error => {
                    console.log(error);
                })
                .finally(() => {
                    this.tableLoading = false;
                    this.componentOverlay = false;
                });
        },

        buyCredit() {
            axios
                .post(
                    "/api/v1/subscribers/" +
                        this.profileId +
                        "/purchase-histories",
                    {
                        amount: this.credit
                    }
                )
                .then(response => {
                    this.tableContacts = response.data;
                    swal.fire({
                        type: "success",
                        icon: "success",
                        title: "Purchase Request Sent!",
                        showConfirmButton: false,
                        timer: 1500
                    });
                })
                .catch(error => {
                    console.log(error);
                })
                .finally(() => {
                    this.fetchHistories();
                    this.formCreditDialog = false;
                    this.credit = 0;
                });
        },

        formattedAmount(number) {
            let internationalNumberFormat = new Intl.NumberFormat("en-US");
            return internationalNumberFormat.format(number);
        },

        statusColor(status) {
            if (status == "COMPLETED") {
                return "success";
            } else if (status == "PENDING") {
                return "primary";
            } else if (status == "CANCELLED" || status == "DECLINED") {
                return "error";
            }
        }
    }
};
</script>
