<template>
    <perfect-scrollbar
        class="quick-search-wrapper scroll"
        style="max-height: 40vh; position: relative;"
        v-bind:options="{ suppressScrollX: true }"
    >
        <div class="quick-search-result">
            <!--begin::Message-->
            <div v-if="data.length === 0" class="text-muted d-none">
                No record found
            </div>
            <!--end::Message-->

            <template v-for="(item, i) in data">
                <div
                    :key="i"
                    class="d-flex align-items-center flex-grow-1 mb-2"
                >
                    <div class="d-flex flex-column ml-3 mt-2 mb-2">
                        <router-link
                            :to="item.url"
                            class="font-weight-bold text-dark text-hover-primary"
                        >
                            {{ item.text }}
                        </router-link>
                    </div>
                </div>
            </template>
        </div>
    </perfect-scrollbar>
</template>

<script>
export default {
    name: "KTSearchResult",
    props: {
        data: Array
    }
};
</script>
