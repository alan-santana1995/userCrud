import './bootstrap';
import {createApp} from 'vue';
import UserTable from './views/UserTable.vue';
import UserForm from './views/UserForm.vue';
import User from './views/User.vue';
import Toaster from "@meforma/vue-toaster";

const app = createApp({
    components: {
        UserTable,
        UserForm,
        User,
    }
});

app.use(Toaster, {
    position: 'top-right',
    duration: 5000,
    maxToasts: 3,
    queue: true
});

app.mount("#app");

window.app = app;
