export type MaskFunction = (value: string) => string;

export const cnpjMask: MaskFunction = (value: string) => {
  return value
    .replace(/\D/g, "")
    .replace(/^(\d{2})(\d)/, "$1.$2")
    .replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3")
    .replace(/\.(\d{3})(\d)/, ".$1/$2")
    .replace(/(\d{4})(\d)/, "$1-$2")
    .slice(0, 18);
};

export const cpfMask: MaskFunction = (value: string) => {
  return value
    .replace(/\D/g, "")
    .replace(/(\d{3})(\d)/, "$1.$2")
    .replace(/(\d{3})(\d)/, "$1.$2")
    .replace(/(\d{3})(\d{1,2})$/, "$1-$2")
    .slice(0, 14);
};

export const phoneMask: MaskFunction = (value: string) => {
  return value
    .replace(/\D/g, "")
    .replace(/(\d{2})(\d)/, "($1) $2")
    .replace(/(\d{5})(\d)/, "$1-$2")
    .slice(0, 15);
};

export const timeMask: MaskFunction = (value: string) => {
  return value
    .replace(/\D/g, "")
    .replace(/^(\d{2})(\d)/, "$1:$2")
    .slice(0, 5);
};

export const unmask: MaskFunction = (value: string) => {
  return value.replace(/\D/g, "");
};

export const unmaskCpf: MaskFunction = (value: string) => {
  return unmask(value);
};

export const unmaskCnpj: MaskFunction = (value: string) => {
  return unmask(value);
};

export const unmaskPhone: MaskFunction = (value: string) => {
  return unmask(value);
};
