import Banner from "./Banner";
import Logo from "./Logo";
import CompanyName from "./CompanyName";
import Address from "./Address";

export default function CardapioHeader() {
  return (
    <div className="flex flex-col">
      <Banner />
      <Logo />
      <CompanyName name="Cardap.io" />
      <Address address="Rua C - 50 - Loteamento Boa Vista - São Sebastião do Caí" />
    </div>
  );
}
