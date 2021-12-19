<template>
    <div>
        <v-navigation-drawer v-model="drawer" app temporary light>
            <!-- <v-list>
                <v-list-item>
                    <v-list-item-avatar>
                        <img src="/img/logo.png" alt="Logo" to="/" />
                    </v-list-item-avatar>
                    <v-list-item-content>
                        <v-list-item-title class="title"
                            >SMSOn</v-list-item-title
                        >
                    </v-list-item-content>
                </v-list-item>
            </v-list> -->

            <v-divider />

            <v-list dense>
                <v-list-item
                    v-for="([icon, text, link], i) in items"
                    :key="i"
                    link
                    :to="link"
                >
                    <v-list-item-icon class="justify-center">
                        <v-icon>{{ icon }}</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title class="subtitile-1">{{
                            text
                        }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-app-bar
            app
            :color="color"
            :flat="flat"
            light
            :class="{
                expand: flat,
                'px-0': $vuetify.breakpoint.xs,
                'px-15': $vuetify.breakpoint.mdAndUp
            }"
        >
            <v-toolbar-title class="primary--text">
                HOSPITAL TRACKER
            </v-toolbar-title>
            <v-spacer />
            <v-app-bar-nav-icon
                @click.stop="drawer = !drawer"
                class="mr-4"
                v-if="isXs"
            />
            <div v-else>
                <v-btn
                    :ripple="false"
                    id="no-background-hover"
                    v-if="this.$route.path == '/'"
                    text
                    @click="$vuetify.goTo(0)"
                >
                    <span class="mr-2">HOME</span>
                </v-btn>
                <v-btn
                    :ripple="false"
                    id="no-background-hover"
                    v-else
                    text
                    to="/"
                >
                    <span class="mr-2">HOME</span>
                </v-btn>
                <v-btn
                    :ripple="false"
                    id="no-background-hover"
                    text
                    to="/login"
                >
                    <span class="mr-2">LOG-IN</span>
                </v-btn>
            </div>
        </v-app-bar>
    </div>
</template>

<style scoped>
.v-toolbar {
    transition: 0.6s;
}

.v-toolbar__content {
    flex-direction: column !important;
}

.expand {
    height: 80px !important;
    padding-top: 10px;
}

#no-background-hover {
    font-family: "Rubik", sans-serif !important;
    font-weight: normal !important;
}

#no-background-hover:before {
    color: transparent;
}

#no-background-hover span:hover,
#no-background-hover span:focus {
    color: #00695c !important;
}

#btn-signup {
    font-family: "Rubik", sans-serif !important;
    font-weight: normal !important;
}

#btn-signup:before {
    color: transparent;
}

#btn-signup:hover,
#btn-signup:focus {
    background-color: #8ecf8d !important;
}
</style>

<script>
export default {
    data() {
        return {
            drawer: null,
            isXs: false,
            items: [
                ["mdi-home-outline", "Home", "/#hero"],
                ["mdi-login", "Login", "/login"],
                ["mdi-account-plus", "Register", "/register"]
            ]
        };
    },
    props: {
        color: String,
        flat: Boolean
    },
    methods: {
        onResize() {
            this.isXs = window.innerWidth < 850;
        }
    },

    watch: {
        isXs(value) {
            if (!value) {
                if (this.drawer) {
                    this.drawer = false;
                }
            }
        }
    },
    mounted() {
        this.onResize();
        window.addEventListener("resize", this.onResize, { passive: true });
    }
};
</script>
