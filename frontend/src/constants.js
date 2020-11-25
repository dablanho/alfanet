import app from "@/main";

const odemeTurleri = [
    {
        key: 0,
        value: app.$t("GENERAL.NAKIT")
    },
    {
        key: 1,
        value: app.$t("GENERAL.KREDI_KARTI")
    },
    {
        key: 2,
        value: app.$t("GENERAL.CEK")
    },
    {
        key: 3,
        value: app.$t("GENERAL.SENET")
    }
];

const apiUrl =
    process.env.NODE_ENV === "development"
        ? "http://localhost:8000"
        : "http://api.servisotomasyon.com";
export { odemeTurleri, apiUrl };
