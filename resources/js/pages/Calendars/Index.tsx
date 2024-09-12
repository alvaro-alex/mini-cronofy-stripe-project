import { usePage } from '@inertiajs/react';
import { Calendar, PaginatedData } from '@/types';
import MainLayout from '@/Layouts/MainLayout';
import Table from '@/Components/Table/Table';
import Pagination from '@/Components/Pagination/Pagination';
import { CheckboxInput } from '@/Components/Form/CheckboxInput';

const Index = () => {
  const { calendars, isConnected } = usePage<{
    calendars: Calendar[];
    isConnected: boolean }>().props;

  return(
    <div>
      <h1 className="mb-8 text-3xl font-bold">User Calendars</h1>
      { !isConnected &&
      (<div className="flex items-center justify-between mb-6">
        <button
          className="btn-indigo focus:outline-none"
          onClick = {() => window.location.href = route('auth.cronofy')}
        >
          <span>Connect to Cronofy</span>
        </button>
      </div>)}
      <Table
        columns={[
          { label: 'Source', name: 'source' },
          { label: 'Calendar Name', name: 'calendar_name' },
          { label: 'Calendar Primary', name: 'calendar_primary',
            renderCell: row => (
              <CheckboxInput
                checked={Boolean(row.calendar_primary)}
              />
            )
          }
        ]}
        rows={calendars}
        getRowDetailsUrl={row => '#'}
      />
    </div>
  )
};

Index.layout = (page: React.ReactNode) => (
  <MainLayout title="Calendars" children={page} />
);

export default Index;
