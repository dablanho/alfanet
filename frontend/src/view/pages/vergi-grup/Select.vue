<template>
    <div>
        <div class="col-12 float-left p-0 d-block">
            <div
                v-if="getVergiGrupSelect.length > 0"
                class="float-left p-0 form-group col-12"
            >
                <select
                    @input="$emit('input', $event.target.value)"
                    class="form-control"
                    @change="
                        $emit(
                            'fiyatlandirma-change',
                            getVergiGrupSelect.find(
                                cur => +cur.id === +$event.target.value
                            )
                        )
                    "
                >
                    <option value="0">{{ $t("GENERAL.SELECT") }}</option>
                    <option
                        v-for="(value, key) in getVergiGrupSelect"
                        :key="key"
                        :value="value.id"
                        >{{ value.ad }}</option
                    >
                </select>
                <small id="emailHelp" class="form-text">{{
                    $t(selectText)
                }}</small>
            </div>
            <router-link v-else to="/vergi-grup">
                <span class="alert d-block alert-dark">
                    {{ $t("VERGIGRUP.NOT_FOUND_ADD") }}
                </span>
                <small class="form-text">{{ $t(selectText) }}</small>
            </router-link>
        </div>
    </div>
</template>

<script>
import { GET_SELECT as GET_VERGI_GRUP_SELECT } from "@/core/services/store/vergi-grup.module";
import { mapGetters } from "vuex";
export default {
    name: "vergiGrupSelect",
    props: ["selectText"],
    mounted() {
        this.$store.dispatch(GET_VERGI_GRUP_SELECT);
    },
    computed: {
        ...mapGetters(["getVergiGrupSelect"])
    }
};
</script>
