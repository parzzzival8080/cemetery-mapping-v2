<template>
    <v-navigation-drawer
        id="app-drawer"
        v-model="inputValue"
        app
        floating
        permanent
        mobile-breakpoint="991"
        width="260"
    >
        <v-list dense>
            <v-list-item
                v-for="(link, i) in links"
                :key="i"
                :to="link.to"
                active-class="primary"
                v-if="userPermission(link.module)"
                class="v-list-item"
            >
                <v-list-item-action>
                    <v-icon>{{ link.icon }}</v-icon>
                </v-list-item-action>
                <v-list-item-title v-text="link.text" />
            </v-list-item>
        </v-list>
        <template v-slot:append>
            <v-list dense>
                <v-list-item @click.stop="logout">
                    <v-list-item-action>
                        <v-icon>mdi-exit-to-app</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title class="subtitle-2"
                            >Logout</v-list-item-title
                        >
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </template>
    </v-navigation-drawer>
</template>

<script>
// Utilities
import { mapMutations, mapState } from "vuex";

export default {
    props: {
        opened: {
            type: Boolean,
            default: false
        }
    },
    data: () => ({
        logo: "favicon.ico",
        links: [
            {
                to: "/admin/dashboard",
                icon: "mdi-view-dashboard",
                text: "Dashboard",
                module: "dashboard"
            },
            {
                to: "/admin/hospitals",
                icon: "mdi-hospital-building",
                text: "Hospitals",
                module: "hospital"
            },
            {
                to: "/admin/hospital-rooms",
                icon: "mdi-bed-empty",
                text: "Rooms",
                module: "room"
            },
            {
                to: "/admin/users",
                icon: "mdi-account-circle",
                text: "Users",
                module: "user"
            }
        ],
        // userRole: sessionStorage.getItem("user-type"),
        userRole: "ADMINISTRATOR"
    }),
    computed: {
        ...mapState("app", ["color"]),
        inputValue: {
            get() {
                return this.$store.state.app.drawer;
            },
            set(val) {
                this.setDrawer(val);
            }
        },
        items() {
            return this.$t("Layout.View.items");
        }
    },

    methods: {
        ...mapMutations("app", ["setDrawer", "toggleDrawer"]),
        userPermission(module) {
            var modules = {
                dashboard: true,
                hospital: true,
                user: true,
                room: true
            };
            var permissions = {
                ADMINISTRATOR: {
                    ...modules
                }
                // SUBSCRIBER: {
                //     ...modules
                // }
            };
            return permissions[this.userRole][module];
        },

        logout() {
            axios
                .get("/api/v1/logout")
                .then(response => {
                    if (response.data.errors) {
                        this.error = response.data.errors;
                        return;
                    }
                    sessionStorage.clear();
                    this.$router.push("/signin");
                })
                .catch(error => {
                    if (error.response.data.message == "Unauthenticated.") {
                        sessionStorage.clear();
                        this.$router.push("/signin");
                    }
                });
        }
    }
};
</script>

<style lang="scss">
#app-drawer {
    .v-list__tile {
        border-radius: 4px;

        &--buy {
            margin-top: auto;
            margin-bottom: 17px;
        }
    }

    .v-list .v-list-item--active {
        color: white !important;
    }
}
</style>
