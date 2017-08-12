module.exports = {

    // binary to decimal
    bin2dec: function(num){
        return ConvertBase(num).from(2).to(10);
    },
    bin2hex: function (num) {
        return ConvertBase(num).from(2).to(16);
    },
    dec2bin: function (num) {
        return ConvertBase(num).from(10).to(2);
    },
    dec2hex: function (num) {
        return ConvertBase(num).from(10).to(16);
    },
    hex2bin: function (num) {
        return ConvertBase(num).from(16).to(2);
    },
    hex2dec: function (num) {
        return ConvertBase(num).from(16).to(10);
    },
    uintToInt: function(uint, nbit) {
        nbit = +nbit || 32;
        if (nbit > 32) throw new RangeError('uintToInt only supports ints up to 32 bits');
        uint <<= 32 - nbit;
        uint >>= 32 - nbit;
        return uint;
    }

}

var ConvertBase = function (num) {
      return {
          from : function (baseFrom) {
              return {
                  to : function (baseTo) {
                      return parseInt(num, baseFrom).toString(baseTo);
                  }
              };
          }
      };
  };
