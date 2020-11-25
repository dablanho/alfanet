<template>
    <!-- begin:: Header Topbar -->
    <div class="topbar">
        <!--begin: Search -->
        <b-dropdown
            size="sm"
            id="kt_quick_search_toggle"
            variant="link"
            toggle-class="topbar-item text-decoration-none"
            no-caret
            right
            no-flip
        >
            <template v-slot:button-content>
                <div class="btn btn-icon btn-clean btn-lg btn-dropdown mr-1">
                    <span class="svg-icon svg-icon-xl svg-icon-primary">
                        <inline-svg src="media/svg/icons/General/Search.svg" />
                    </span>
                </div>
            </template>
            <b-dropdown-text tag="div" style="width: 350px;">
                <KTSearchDefault></KTSearchDefault>
            </b-dropdown-text>
        </b-dropdown>
        <!--end: Search -->
        <!--begin: Language bar -->
        <div class="topbar-item">
            <b-dropdown
                size="sm"
                variant="link"
                toggle-class="btn btn-icon btn-clean btn-dropdown btn-lg mr-1 text-decoration-none"
                no-caret
                right
                no-flip
            >
                <template v-slot:button-content>
                    <img
                        class="h-20px w-20px rounded-sm"
                        :src="languageFlag || getLanguageFlag"
                        alt=""
                    />
                </template>
                <b-dropdown-text tag="div" style="width: 175px;">
                    <KTDropdownLanguage
                        v-on:language-changed="onLanguageChanged"
                    ></KTDropdownLanguage>
                </b-dropdown-text>
            </b-dropdown>
        </div>
        <!--end: Language bar -->

        <!--begin: User Bar -->
        <KTQuickUser></KTQuickUser>
        <!--end: User Bar -->
    </div>
    <!-- end:: Header Topbar -->
</template>

<style lang="scss">
.topbar {
    .dropdown-toggle {
        padding: 0;
        &:hover {
            text-decoration: none;
        }

        &.dropdown-toggle-no-caret {
            &:after {
                content: none;
            }
        }
    }

    .dropdown-menu {
        margin: 0;
        padding: 0;
        outline: none;
        .b-dropdown-text {
            padding: 0;
        }
    }
}
</style>

<script>
import KTSearchDefault from "@/view/layout/extras/dropdown/SearchDefault.vue";
import KTDropdownLanguage from "@/view/layout/extras/dropdown/DropdownLanguage.vue";
import KTQuickUser from "@/view/layout/extras/offcanvas/QuickUser.vue";
import i18nService from "@/core/services/i18n.service.js";

export default {
    name: "KTTopbar",
    data() {
        return {
            languageFlag: "",
            languages: i18nService.languages
        };
    },
    components: {
        KTSearchDefault,
        KTDropdownLanguage,
        KTQuickUser
    },
    methods: {
        onLanguageChanged() {
            this.languageFlag = this.languages.find(val => {
                return val.lang === i18nService.getActiveLanguage();
            }).flag;
        }
    },
    computed: {
        getLanguageFlag() {
            return this.onLanguageChanged();
        }
    }
};
</script>
