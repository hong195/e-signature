<template>
  <div>
    <div style="display: flex;  align-items: center; justify-content: center; height: 100%; flex-direction: column;">
      <table>
        <tbody>
          <tr>
            <td width="130" style="padding-right: 15px;">
              <p>
                <img width="120"
                     height="120"
                     style="border-radius: 50%;
               border-width: 5px;
               border-color:#004b9e;
               border-style: solid; object-fit: cover"
                     :src="checkValue(url, 'https://via.placeholder.com/400')" alt=""
                >
              </p>
              <p style="text-align: center; margin-top: 20px;">
                <img width="100" src="https://oxymed.uz/uploads/card/oxymed/oxymed_logo.png" alt="">
              </p>
            </td>
            <td width="280" valign="top">
              <h3 style="font-size: 18px; color: rgb(0, 0, 0); font-weight: bold; margin-bottom: 5px; margin-top: 0;
            font-family: Arial, sans-serif;
        "
              >
                {{ checkValue(schema.first_name.value, 'Имя') }} {{ checkValue(schema.last_name.value, 'Фамилия') }}
              </h3>

              <p style="font-size: 14px;
                  font-family: Arial, sans-serif;
                  margin-bottom: 2px;
                  margin-top: 0;
                  padding-top: 2px;
                  color: #fff;
                  padding-bottom: 2px;
                  "
              >
                <span style="background-color: #004b9e; padding-left: 5px; padding-top: 4px; padding-bottom: 4px; font-weight: bold;
                  padding-right: 5px;"
                >
                  {{ checkValue(schema.position.value, 'Должность') }}
                </span>
              </p>
              <p style="margin-top: 25px; margin-bottom: 25px; width: 100%; height: 3px; border-bottom: 1px solid #004b9e;" />

              <p style="margin-top: 5px; margin-bottom: 5px; font-size: 12px; font-family: Arial, sans-serif">
                <a href="tel:+998 90 908 10 08" style="text-decoration: none; color: #000;">
                  <img width="13px" src="https://oxymed.uz/uploads/card/oxymed/phone_b.png" alt=""> {{ '+998 '+checkValue(schema.phone.value.length === 12 ? schema.phone.value : null, '90 123 45 67') }}</a>
              </p>
              <p style="margin-top: 5px; margin-bottom: 5px; font-size: 12px; color: #000; font-family: Arial, sans-serif">
                <a href="http://t.me/ceo_oxymed" style="text-decoration: none; color: #000;">
                  <img width="13px"
                       src="https://oxymed.uz/uploads/card/oxymed/telegram_b.png"
                       alt=""
                  > {{ '+998 '+checkValue(schema.phone.value.length === 12 ? schema.phone.value : null, '90 123 45 67') }}</a>
              </p>

              <p style="margin-top: 5px; margin-bottom: 5px; font-size: 12px; color: #000; font-family: Arial, sans-serif">
                <a href="mailto:aziza.hudayberdieva@oxymed.uz" style="text-decoration: none; color: #000;">
                  <img width="13px"
                       src="https://oxymed.uz/uploads/card/oxymed/mail_b.png"
                       alt=""
                  >                   {{ checkEmail(schema.email.value, 'example@gmail.com') }}</a>
              </p>
              <p style="margin-top: 5px; margin-bottom: 5px; font-size: 12px; color: #000; font-family: Arial, sans-serif">
                <a href="https://www.oxymed.uz" style="text-decoration: none; color: #000;">
                  <img width="14px"
                       src="https://oxymed.uz/uploads/card/oxymed/web_b.png" alt=""
                  >
                  oxymed.uz</a>
              </p>
            <!--            <p style="margin-top: 5px; margin-bottom: 5px; font-size: 12px; color: #000; font-family: Arial, sans-serif">-->
            <!--              <a href="#" style="text-decoration: none; color: #000;">-->
            <!--                <img width="14px"-->
            <!--                     src="https://oxymed.uz/uploads/card/oxymed/map_b.png" alt=""-->
            <!--                >-->
            <!--                Uzbekistan, 100044, Tashkent, Bezakchilik 18A</a>-->
            <!--            </p>-->
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
<script>
  export default {
    name: 'ApplicationPreview',
    props: {
      url: {
        type: String,
      },
      schema: {
        type: [Array, Object],
      },
    },
    methods: {
      checkEmail (v, sample) {
        if (/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(v)) {
          return v
        } else { return sample }
      },
      checkValue (val, sample) {
        if (val) { return val } else return sample
      },
    },
  }
</script>
<style lang="scss" scoped>
.circledImage--div {
  position: relative;
  height: 100%;
}

.circledImage {
  border: 5px solid #7fb94a;
  border-radius: 50%;
  position: absolute;
  top: 18%;
}

.position {
  color: white;
  background: #7fb94a;
  padding: 5px;
  width: 100%;
}
</style>
