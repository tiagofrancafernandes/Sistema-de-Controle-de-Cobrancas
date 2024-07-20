// Static import
// import OpenedEyeIcon from '@SvgIcons/Icons/OpenedEyeIcon.vue';

// Dynamic import (Prefer this)
const OpenedEyeIcon = () => import('@SvgIcons/Icons/OpenedEyeIcon.vue');

const iconComponents = {
    // OpenedEyeIcon,
    // SvgIconOpenedEye: OpenedEyeIcon,
    // SvgIcon2: OpenedEyeIcon,
    // 'heroicon-s-arrow-down-circle': OpenedEyeIcon,
}

export default iconComponents;
