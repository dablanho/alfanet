<template>
    <div class="col-12 float-left p-0 d-block">
        <div v-if="getSelectStaff">
            <select
                @input="$emit('input', $event.target.value)"
                class="form-control"
            >
                <option value="0">{{ $t("GENERAL.SELECT") }}</option>
                <option
                    v-for="(value, key) in getSelectStaff"
                    :key="key"
                    :value="value.id"
                    >{{ value.ad }}</option
                >
            </select>
            <small id="emailHelp" class="form-text">{{ $t(selectText) }}</small>
        </div>
    </div>
</template>

<script>
import { SELECT_STAFF } from "@/core/services/store/personel.module";
import { mapGetters } from "vuex";
export default {
    name: "PersonelSelect",
    props: ["selectText"],

    mounted() {
        this.$store.dispatch(SELECT_STAFF);
    },
    computed: {
        ...mapGetters(["getSelectStaff"])
    }
};
</script>
