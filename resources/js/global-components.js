import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';

import CustomTextInput from '@/Components/CustomTextInput.vue';
import BasicCard from '@/Components/Blocks/BasicCard.vue';
import BasicInput from '@/Components/Blocks/BasicInput.vue';

const components = {
    VInput: BasicInput,
    Input: BasicInput,
    BasicInput,
    BasicCard,
    TextInput,
    InputLabel,
    CustomTextInput,
};

const install = app => {
    for (let [name, component] of Object.entries(components)) {
        app.component(name, component);
    }
}

/* eslint-disable */
export default {
    install,
};
