import MainMenuItem from '@/Components/Menu/MainMenuItem';
import { Building, CircleGauge, Printer, Users } from 'lucide-react';

interface MainMenuProps {
  className?: string;
}

export default function MainMenu({ className }: MainMenuProps) {
  return (
    <div className={className}>
      <MainMenuItem
        text="Dashboard"
        link="dashboard"
        icon={<CircleGauge size={20} />}
      />
      <MainMenuItem
        text="Cronofy"
        link="cronofy.calendars"
        icon={<Printer size={20} />}
      />
      <MainMenuItem
        text="Stripe"
        link="stripe.subscription"
        icon={<Printer size={20} />}
      />
    </div>
  );
}
