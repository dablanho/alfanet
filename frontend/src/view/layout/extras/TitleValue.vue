<template>
    <div>
        <div class="mb-3 TitleValue">
            <div class="col-12 pt-4 d-flex pb-2 float-left border-bottom">
                <div class="col-4 float-left">
                    <b>{{ title }}</b>
                </div>
                <div class="float-left col-1">
                    <span>:</span>
                </div>
                <div class="col-7 float-left">
                    <span>{{ dataValue }}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "TitleValue",
    props: ["title", "value", "t"],

    computed: {
        dataValue() {
            return this.t
                ? window.moment(this.value).format("DD.MM.YYYY")
                : this.value;
        }
    }
};
</script>
