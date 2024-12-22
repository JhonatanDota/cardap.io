import FeatureHighlight from "./components/FeatureHighlight";

import HamburguerIcon from "./icons/HamburguerIcon";
import PizzaIcon from "./icons/PizzaIcon";
import DinnerIcon from "./icons/DinnerIcon";
import CupCakeIcon from "./icons/CupCakeIcon";

export default function Home() {
  return (
    <div className="md:w-3/4 md:m-auto flex flex-col justify-center items-center gap-5 md:gap-8 m-10 font-nunito-sans">
      <img src="/images/logos/CardapioBlackLogo.svg" alt="Cardap.io" />

      <h3 className="text-lg md:text-4xl font-bold text-orange-600 text-center my-5">
        Crie e personalize seu Cardap.io de forma descomplicada e rápida.
      </h3>

      <div className="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-8">
        <FeatureHighlight
          icon={<HamburguerIcon />}
          title="Crie"
          text="Crie o seu Cardap.io e facilite a sua vida e a do seu cliente na hora do pedido."
        />

        <FeatureHighlight
          icon={<PizzaIcon />}
          title="Personalize"
          text="Personalize o Cardap.io com a cara do seu delivery."
        />

        <FeatureHighlight
          icon={<DinnerIcon />}
          title="Gerencie"
          text="Gerencie o progresso das suas vendas, acompanhando as entregas e as finanças."
        />

        <FeatureHighlight
          icon={<CupCakeIcon />}
          title="Descomplique"
          text="Descomplique, centralize tudo do seu delivery em um só lugar."
        />
      </div>

      <button className="text-base md:text-lg p-4 md:p-6 rounded-md font-extrabold uppercase bg-yellow-400">
        Quero Criar o MEU!
      </button>
    </div>
  );
}
