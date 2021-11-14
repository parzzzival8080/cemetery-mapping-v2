<template>
    <v-container fill-height>
        <v-row justify="center">
            <v-col cols="12" md="8" class="dashboard-stats">
                <v-row class="mt-4">
                    <v-col>
                        <h1>Dashboard</h1>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col
                        sm="6"
                        xs="12"
                        md="6"
                        lg="6"
                        xl="4"
                        v-for="(stat, index) in stats"
                        :key="index"
                    >
                        <material-stats-card
                            :color="stat.color"
                            :icon="stat.icon"
                            :title="stat.title"
                            :value="formattedAmount(stat.value)"
                            :small-value="stat.smallvalue"
                            :sub-icon="stat.subicon"
                            :sub-icon-color="stat.subiconcolor"
                            :sub-text="stat.subtext"
                            :sub-text-color="stat.subtextcolor"
                        />
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            stats: [
                {
                    color: "green",
                    icon: "mdi-hospital-building",
                    title: "Hospitals",
                    value: "6",
                    smallvalue: "",
                    subicon: "mdi-update",
                    subiconcolor: "",
                    subtext: "Just Updated",
                    subtextcolor: ""
                },
                {
                    color: "orange",
                    icon: "mdi-bed",
                    title: "Rooms Available",
                    value: "132",
                    smallvalue: "",
                    subicon: "mdi-update",
                    subiconcolor: "",
                    subtext: "Just Updated",
                    subtextcolor: ""
                },
                {
                    color: "info",
                    icon: "mdi-account-group",
                    title: "Occupants",
                    value: "0",
                    smallvalue: "",
                    subicon: "mdi-update",
                    subiconcolor: "",
                    subtext: "Just Updated",
                    subtextcolor: ""
                }
            ],
            rules: {
                //Form Field Rules
                required: [v => !!v || "Field is required"]
            }
        };
    },

    computed: {},

    methods: {
        fetchDashboard() {
            axios
                .get("/api/v1/dashboard")
                .then(response => {
                    let datas = response.data;
                    let stats = datas.total;
                    stats = {
                        ...stats,
                        ...this.subscriber.subscriber_plan
                    };
                    let i = 0;
                    let keys =
                        sessionStorage.getItem("user-type") == "ADMINISTRATOR"
                            ? ["orders", "establishments", "group", "contact"]
                            : ["group", "contact", "credits", "available"];
                    this.stats.forEach(stat => {
                        stat.value = stats[keys[i]].toString();
                        if (stat.title == "SMS Remaining") {
                            stat.subtext = this.subscriber.plan.name;
                        }
                        i++;
                    });
                })
                .catch(error => {
                    console.log(error);
                })
                .finally(() => {
                    this.componentOverlay = false;
                });
        },

        formattedAmount(number) {
            let internationalNumberFormat = new Intl.NumberFormat("en-US");
            return internationalNumberFormat.format(number);
        }
    },

    createds() {
        // this.fetchDashboard();
    }
};
</script>
