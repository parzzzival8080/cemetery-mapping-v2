<template>
    <v-app>
        <views-navigation :color="color" :flat="flat" />
        <div class="signin">
            <v-container class="signin-container" fluid fill-height>
                <v-row justify="center">
                    <v-col cols="12" md="8">
                        <v-container
                            width="80vw"
                            max-width="100vw"
                            min-width="400"
                            fluid
                        >
                            <v-row justify="center" class="mt-16">
                                <v-col id="column-1" cols="12" lg="8" class="">
                                    <v-row justify="center" class="text-center">
                                        <h1
                                            class="font-weight-bold primary--text"
                                        >
                                            Register
                                        </h1>
                                    </v-row>
                                    <v-row justify="center">
                                        <v-col cols="12" md="9">
                                            <v-card
                                                class="transparent elevation-0"
                                            >
                                                <v-container>
                                                    <v-form
                                                        ref="form"
                                                        lazy-validation
                                                    >
                                                        <v-row
                                                            justify="center"
                                                        >
                                                            <v-col
                                                                cols="12"
                                                                md="6"
                                                                ><v-text-field
                                                                    v-model="
                                                                        user.first_name
                                                                    "
                                                                    :error-messages="
                                                                        formSignUpError.first_name
                                                                    "
                                                                    :rules="
                                                                        rules.required
                                                                    "
                                                                    label="First Name"
                                                                ></v-text-field
                                                            ></v-col>
                                                            <v-col
                                                                cols="12"
                                                                md="6"
                                                                ><v-text-field
                                                                    v-model="
                                                                        user.last_name
                                                                    "
                                                                    :error-messages="
                                                                        formSignUpError.last_name
                                                                    "
                                                                    :rules="
                                                                        rules.required
                                                                    "
                                                                    label="Last Name"
                                                                ></v-text-field
                                                            ></v-col>
                                                        </v-row>
                                                        <v-row
                                                            justify="center"
                                                        >
                                                            <v-col
                                                                cols="12"
                                                                md="6"
                                                                ><v-text-field
                                                                    v-model="
                                                                        user.phone_number
                                                                    "
                                                                    :error-messages="
                                                                        formSignUpError.phone_number
                                                                    "
                                                                    :rules="
                                                                        rules.contactRules
                                                                    "
                                                                    prefix="(+63)"
                                                                    maxlength="10"
                                                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                                    label="Contact Number"
                                                                ></v-text-field
                                                            ></v-col>
                                                            <v-col
                                                                cols="12"
                                                                md="6"
                                                                ><v-text-field
                                                                    v-model="
                                                                        user.email
                                                                    "
                                                                    :error-messages="
                                                                        formSignUpError.email
                                                                    "
                                                                    :rules="
                                                                        rules.emailRules
                                                                    "
                                                                    label="Email"
                                                                ></v-text-field
                                                            ></v-col>
                                                        </v-row>
                                                        <v-row
                                                        <v-row
                                                            justify="center"
                                                        >
                                                            <v-col
                                                                cols="12"
                                                                ><v-text-field
                                                                    v-model="
                                                                        user.password
                                                                    "
                                                                    label="Password"
                                                                    id="password"
                                                                    name="password"
                                                                    :append-icon="
                                                                        visible
                                                                            ? 'mdi-eye-off'
                                                                            : 'mdi-eye'
                                                                    "
                                                                    @click:append="
                                                                        visible = !visible
                                                                    "
                                                                    :rules="
                                                                        rules.passwordRules
                                                                    "
                                                                    :type="
                                                                        visible
                                                                            ? 'text'
                                                                            : 'password'
                                                                    "
                                                                    @keydown.enter="
                                                                        register()
                                                                    "
                                                                ></v-text-field
                                                            ></v-col>
                                                        </v-row>
                                                        <v-row
                                                            justify="center"
                                                        >
                                                            <v-col
                                                                cols="12"
                                                            >
                                                                <v-btn
                                                                    color="primary"
                                                                    large
                                                                    block
                                                                    @click="
                                                                        sendOTP(),
                                                                            (loader =
                                                                                'loading')
                                                                    "
                                                                    class="ma-2"
                                                                    :loading="
                                                                        loading
                                                                    "
                                                                    :disabled="
                                                                        loading
                                                                    "
                                                                >
                                                                    Register
                                                                    <template
                                                                        v-slot:loader
                                                                    >
                                                                        <span
                                                                            class="custom-loader"
                                                                        >
                                                                            <v-icon
                                                                                light
                                                                                >mdi-cached</v-icon
                                                                            >
                                                                        </span>
                                                                    </template>
                                                                </v-btn>
                                                            </v-col>
                                                        </v-row>
                                                    </v-form>
                                                </v-container>
                                            </v-card>
                                        </v-col>
                                    </v-row>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-col>
                </v-row>
            </v-container>
            </div>
        </div>
    </v-app>
</template>

<script>
export default {
    name: "app",

    data() {
        return {
            loading: false,
            user: {
                first_name: null,
                last_name: null,
                email: null,
                plan_id: 1,
                referral_code: null,
                phone_number: null,
                password: null
            },
            visible: false,
            formSignUpError: {
                first_name: null,
                last_name: null,
                email: null,
                phone_number: null
            },
            rules: {
                required: [
                    v => !!v || "Field is required",
                    v =>
                        (!!v && v.length <= 255) ||
                        " Field should not be more than 255 characters"
                ],
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
                passwordRules: [
                    v => !!v || "Password is required",
                    v =>
                        (!!v && v.length >= 8) ||
                        "Password must be more than 8 characters"
                ]
            },

            fab: null,
            color: "",
            flat: null
        };
    },

    methods: {
        register() {
            if (this.$refs.form.validate()) {
                this.loading = true;
                axios
                    .post("/api/v1/register", {
                        ...this.user,
                        password_confirmation: this.user.password
                    })
                    .then(response => {
                        axios
                            .post("/api/v1/login", {
                                email: this.user.email,
                                password: this.user.password
                            })
                            .then(response => {
                                if (response.data.errors) {
                                    this.error = response.data.errors;
                                    return;
                                }
                                let token = response.data.token;
                                let user_id = response.data.id;
                                let profile_id = response.data.profile_id;
                                let profile_role = response.data.profile_role;
                                let user_type = response.data.role;

                                // Create a local storage item
                                sessionStorage.setItem("user-token", token);
                                sessionStorage.setItem("user-type", user_type);
                                sessionStorage.setItem("user-id", user_id);
                                sessionStorage.setItem(
                                    "profile-id",
                                    profile_id
                                );
                                sessionStorage.setItem(
                                    "profile-role",
                                    profile_role
                                );

                                // Echo.connector.pusher.config.auth.headers[
                                //     "Authorization"
                                // ] = "Bearer " + token;

                                // console.log(
                                //     Echo.connector.pusher.config.auth.headers[
                                //         "Authorization"
                                //     ]
                                // );

                                // Redirect user

                                swal.fire({
                                    position: "top-end",
                                    toast: true,
                                    type: "success",
                                    icon: "success",
                                    text: "Successfully Registered",
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            })
                            .catch(error => {
                                if (
                                    error.response.data.message ==
                                    "Unauthenticated."
                                ) {
                                    sessionStorage.clear();
                                    this.$router.push("/signin");
                                    swal.fire(
                                        "Error!",
                                        error.response.data.message,
                                        "error"
                                    );
                                } else {
                                    swal.fire(
                                        "Invalid Credentials!",
                                        error,
                                        "error"
                                    );
                                }
                            })
                            .finally(x => {
                                this.$router.push("/dashboard");
                            });
                    })
                    .catch(error => {
                        if (error.response.status == 422) {
                            this.formSignUpError = error.response.data.errors;
                            this.loading = false;
                        } else {
                            console.log(error);
                        }
                    })
                    .finally(x => {});
            }
        },

        onScroll(e) {
            if (typeof window === "undefined") return;
            const top = window.pageYOffset || e.target.scrollTop || 0;
            this.fab = top > 60;
        },

        toTop() {
            this.$vuetify.goTo(0);
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

    created() {
        this.toTop();
        const top = window.pageYOffset || 0;
        if (top <= 60) {
            this.color = "transparent";
            this.flat = true;
        }
    },

    beforeRouteEnter(to, from, next) {
        if (sessionStorage.getItem("user-type")) {
            if (sessionStorage.getItem("user-type") == "ADMINISTRATOR") {
                return next("admin/dashboard");
            } else if (sessionStorage.getItem("user-type") == "SUBSCRIBER") {
                return next("/dashboard");
            }
        }
        next();
    }
};
</script>
<style>
.custom-loader {
    animation: loader 1s infinite;
    display: flex;
}
@-moz-keyframes loader {
    from {
        transform: rotate(0);
    }
    to {
        transform: rotate(360deg);
    }
}
@-webkit-keyframes loader {
    from {
        transform: rotate(0);
    }
    to {
        transform: rotate(360deg);
    }
}
@-o-keyframes loader {
    from {
        transform: rotate(0);
    }
    to {
        transform: rotate(360deg);
    }
}
@keyframes loader {
    from {
        transform: rotate(0);
    }
    to {
        transform: rotate(360deg);
    }
}

#otp span {
    color: rgb(71, 77, 87) !important;
    font-weight: normal !important;
}

#otp span strong {
    color: #f59b21;
    font-weight: bold !important;
}

.otp-input {
    width: 60px;
    height: 60px;
    padding: 5px;
    margin: 0 10px;
    font-size: 30px;
    border-radius: 4px;
    border: 1px solid rgba(0, 0, 0, 0.3);
    font-family: "Rubik", sans-serif !important;
}

.error {
    border: 1px solid red !important;
}

input:focus.otp-input {
    outline: 2px solid #f59b21 !important;
}

/* textarea:focus,
input:focus {
    outline: none;
} */

.otp-input::-webkit-inner-spin-button,
.otp-input::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
</style>
