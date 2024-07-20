import CrudTBodyTD from '@CRUD/Parts/Table/TBodyTD.vue';
import CrudTBodyTD2Lines from '@CRUD/Parts/Table/TBodyTD2Lines.vue';
import CrudCustomizableButton from '@CRUD/Parts/Form/Buttons/CustomizableButton.vue';
import CrudFilterInputText from '@EasyCrud/Components/CRUD/Parts/Filter/Inputs/CrudFilterInputText.vue';

// const CrudTBodyTD = () => import('@CRUD/Parts/Table/TBodyTD.vue');
// const CrudTBodyTD2Lines = () => import('@CRUD/Parts/Table/TBodyTD2Lines.vue');
// const CrudCustomizableButton = () => import('@CRUD/Parts/Form/Buttons/CustomizableButton.vue');
// // const CrudFilterInputText = () => import('@EasyCrud/Components/CRUD/Parts/Filter/Inputs/CrudFilterInputText.vue');

const crudComponents = {
    CrudTBodyTD,
    EasyCrudTableColumn: CrudTBodyTD,
    CrudTBodyTD2Lines,
    CrudCustomizableButton,
    // CrudFilterInputText,
}

export default crudComponents;
