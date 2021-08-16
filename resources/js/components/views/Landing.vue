<template>
    <v-app>
        <views-navigation :color="color" :flat="flat" />

        <v-scale-transition>
            <v-btn
                fab
                v-show="fab"
                v-scroll="onScroll"
                dark
                fixed
                bottom
                right
                color="secondary"
                @click="toTop"
            >
                <v-icon>mdi-arrow-up</v-icon>
            </v-btn>
        </v-scale-transition>
    </v-app>
</template>
<script>
export default {
    data() {
        return {
            fab: null,
            color: "",
            flat: null
        };
    },

    created() {
        const top = window.pageYOffset || 0;
        if (top <= 60) {
            this.color = "transparent";
            this.flat = true;
        }
    },

    watch: {
        fab(value) {
            if (value) {
                this.color = "#f8f9fa";
                this.flat = false;
            } else {
                this.color = "transparent";
                this.flat = true;
            }
        }
    },

    methods: {
        onScroll(e) {
            if (typeof window === "undefined") return;
            const top = window.pageYOffset || e.target.scrollTop || 0;
            this.fab = top > 60;
        },
        toTop() {
            this.$vuetify.goTo(0);
        }
    },

    beforeRouteEnter(to, from, next) {
        // if (sessionStorage.getItem("user-type")) {
        //     if (sessionStorage.getItem("user-type") == "ADMINISTRATOR") {
        //         return next("admin/dashboard");
        //     } else if (sessionStorage.getItem("user-type") == "SUBSCRIBER") {
        //         return next("/dashboard");
        //     }
        // }
        // next();
    }
};
</script>
