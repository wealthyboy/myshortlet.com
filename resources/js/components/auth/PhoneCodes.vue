<template>
  <div class="row">
    <div v-if="paymentIsComplete" class="d-flex col-md-12 aligh">
      <booking-complete />
    </div>
    <div v-if="!paymentIsComplete" class="col-md-7">
      <h3>Review and book</h3>
    </div>
    <div v-if="!paymentIsComplete" class="col-md-7">
      <form action="" method="get">
        <booking-property :property="property" />

        <booking-login />

        <div class=" bg-white ">
          <h4 class="card-title p-3 border-bottom">Who's checking in?</h4>
          <div class="card-body">
            <div class="form-row">
              <div class="form-group bmd-form-group col-6">
                <label class="bmd-label-floating">First name</label>
                <input
                  id="first_name"
                  type="text"
                  class="form-control required"
                  name="first_name"
                  v-model="form.first_name"
                  @input="removeError($event)"
                  @blur="vInput($event)"
                  :class="{ 'has-danger': errors.first_name }"
                />
                <span v-if="errors.first_name">
                  <strong class="text-danger">{{
                    formatError(errors.first_name)
                  }}</strong>
                </span>
              </div>
              <div class="form-group bmd-form-group col-6">
                <label class="bmd-label-floating">Last name</label>
                <input
                  id="last_name"
                  type="text"
                  class="form-control required"
                  name="last_name"
                  v-model="form.last_name"
                  @input="removeError($event)"
                  @blur="vInput($event)"
                  :class="{ 'has-danger': errors.last_name }"
                />
                <span v-if="errors.last_name">
                  <strong class="text-danger">{{
                    formatError(errors.last_name)
                  }}</strong>
                </span>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group pt-4 col-3">
                <select name="phone_code" class="form-control required" id="">
                  <template v-for="(map, k) in codes">
                    <option
                      v-for="(code, index) in map"
                      :key="index"
                      :value="code"
                    >
                      {{ index }} (+{{ code }})
                    </option>
                  </template>
                </select>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>
<script>

export default {


  data() {
    return {

      codes: [
        { UK: "44" },
        { USA: "1" },
        { Algeria: "213" },
        { Andorra: "376" },
        { Angola: "244" },
        { Anguilla: "1264" },
        { "Antigua & Barbuda": "1268" },
        { Argentina: "54" },
        { Armenia: "374" },
        { Aruba: "297" },
        { Australia: "61" },
        { Austria: "43" },
        { Azerbaijan: "994" },
        { Bahamas: "1242" },
        { Bahrain: "973" },
        { Bangladesh: "880" },
        { Barbados: "1246" },
        { Belarus: "375" },
        { Belgium: "32" },
        { Belize: "501" },
        { Benin: "229" },
        { Bermuda: "1441" },
        { Bhutan: "975" },
        { Bolivia: "591" },
        { "Bosnia Herzegovina": "387" },
        { Botswana: "267" },
        { Brazil: "55" },
        { Brunei: "673" },
        { Bulgaria: "359" },
        { "Burkina Faso": "226" },
        { Burundi: "257" },
        { Cambodia: "855" },
        { Cameroon: "237" },
        { Canada: "1" },
        { "Cape Verde Islands": "238" },
        { "Cayman Islands": "1345" },
        { "Central African Republic": "236" },
        { Chile: "56" },
        { China: "86" },
        { Colombia: "57" },
        { Comoros: "269" },
        { Congo: "242" },
        { "Cook Islands": "682" },
        { "Costa Rica": "506" },
        { Croatia: "385" },
        { Cuba: "53" },
        { "Cyprus North": "90392" },
        { "Cyprus South": "357" },
        { "Czech Republic": "42" },
        { Denmark: "45" },
        { Djibouti: "253" },
        { Dominica: "1809" },
        { "Dominican Republic": "1809" },
        { Ecuador: "593" },
        { Egypt: "20" },
        { "El Salvador": "503" },
        { "Equatorial Guinea": "240" },
        { Eritrea: "291" },
        { Estonia: "372" },
        { Ethiopia: "251" },
        { "Falkland Islands": "500" },
        { "Faroe Islands": "298" },
        { Fiji: "679" },
        { Finland: "358" },
        { France: "33" },
        { "French Guiana": "594" },
        { "French Polynesia": "689" },
        { Gabon: "241" },
        { Gambia: "220" },
        { Georgia: "7880" },
        { Germany: "49" },
        { Ghana: "233" },
        { Gibraltar: "350" },
        { Greece: "30" },
        { Greenland: "299" },
        { Grenada: "1473" },
        { Guadeloupe: "590" },
        { Guam: "671" },
        { Guatemala: "502" },
        { Guinea: "224" },
        { "Guinea - Bissau": "245" },
        { Guyana: "592" },
        { Haiti: "509" },
        { Honduras: "504" },
        { "Hong Kong": "852" },
        { Hungary: "36" },
        { Iceland: "354" },
        { India: "91" },
        { Indonesia: "62" },
        { Iran: "98" },
        { Iraq: "964" },
        { Ireland: "353" },
        { Israel: "972" },
        { Italy: "39" },
        { Jamaica: "1876" },
        { Japan: "81" },
        { Jordan: "962" },
        { Kazakhstan: "7" },
        { Kenya: "254" },
        { Kiribati: "686" },
        { "Korea North": "850" },
        { "Korea South": "82" },
        { Kuwait: "965" },
        { Kyrgyzstan: "996" },
        { Laos: "856" },
        { Latvia: "371" },
        { Lebanon: "961" },
        { Lesotho: "266" },
        { Liberia: "231" },
        { Libya: "218" },
        { Liechtenstein: "417" },
        { Lithuania: "370" },
        { Luxembourg: "352" },
        { Macao: "853" },
        { Macedonia: "389" },
        { Madagascar: "261" },
        { Malawi: "265" },
        { Malaysia: "60" },
        { Maldives: "960" },
        { Mali: "223" },
        { Malta: "356" },
        { "Marshall Islands": "692" },
        { Martinique: "596" },
        { Mauritania: "222" },
        { Mayotte: "269" },
        { Mexico: "52" },
        { Micronesia: "691" },
        { Moldova: "373" },
        { Monaco: "377" },
        { Mongolia: "976" },
        { Montserrat: "1664" },
        { Morocco: "212" },
        { Mozambique: "258" },
        { Myanmar: "95" },
        { Namibia: "264" },
        { Nauru: "674" },
        { Nepal: "977" },
        { Netherlands: "31" },
        { "New Caledonia": "687" },
        { "New Zealand": "64" },
        { Nicaragua: "505" },
        { Niger: "227" },
        { Nigeria: "234" },
        { Niue: "683" },
        { "Norfolk Islands": "672" },
        { "Northern Marianas": "670" },
        { Norway: "47" },
        { Oman: "968" },
        { Palau: "680" },
        { Panama: "507" },
        { "Papua New Guinea": "675" },
        { Paraguay: "595" },
        { Peru: "51" },
        { Philippines: "63" },
        { Poland: "48" },
        { Portugal: "351" },
        { "Puerto Rico": "1787" },
        { Qatar: "974" },
        { Reunion: "262" },
        { Romania: "40" },
        { Russia: "7" },
        { Rwanda: "250" },
        { "San Marino": "378" },
        { "Sao Tome & Principe": "239" },
        { "Saudi Arabia": "966" },
        { Senegal: "221" },
        { Serbia: "381" },
        { Seychelles: "248" },
        { "Sierra Leone": "232" },
        { Singapore: "65" },
        { "Slovak Republic": "421" },
        { Slovenia: "386" },
        { "Solomon Islands": "677" },
        { Somalia: "252" },
        { "South Africa": "27" },
        { Spain: "34" },
        { "Sri Lanka": "94" },
        { "St. Helena": "290" },
        { "St. Kitts": "1869" },
        { "St. Lucia": "1758" },
        { Sudan: "249" },
        { Suriname: "597" },
        { Swaziland: "268" },
        { Sweden: "46" },
        { Switzerland: "41" },
        { Syria: "963" },
        { Taiwan: "886" },
        { Tajikstan: "7" },
        { Thailand: "66" },
        { Togo: "228" },
        { Tonga: "676" },
        { "Trinidad & Tobago": "1868" },
        { Tunisia: "216" },
        { Turkey: "90" },
        { Turkmenistan: "7" },
        { Turkmenistan: "993" },
        { "Turks & Caicos Islands": "1649" },
        { Tuvalu: "688" },
        { Uganda: "256" },
        { Ukraine: "380" },
        { "United Arab Emirates": "971" },
        { Uruguay: "598" },
        { Uzbekistan: "7" },
        { Vanuatu: "678" },
        { "Vatican City": "379" },
        { Venezuela: "58" },
        { Vietnam: "84" },
        { "Virgin Islands - British": "1284" },
        { "Virgin Islands - US": "1340" },
        { "Wallis & Futuna": "681" },
        { Zambia: "260" },
        { Zimbabwe: "263" },
      ],

  },


};
</script>
