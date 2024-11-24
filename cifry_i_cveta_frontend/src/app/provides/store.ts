import { employeeModule, myModule, officeModule } from '@/entities'
import { equipmentModule } from '@/entities/equipment'
import { maintenanceModule } from '@/entities/maintenance'
import { recordModule } from '@/entities/record'
import { schemaobjectModule } from '@/entities/schema-object'
import { createStore } from 'vuex'

export const store = createStore({
    modules: {
        ['me']: myModule.module,
        ['employee']: employeeModule.module,
        ['maintenance']: maintenanceModule.module,
        ['equipment']: equipmentModule.module,
        ['record']: recordModule.module,
        ['office']: officeModule.module,
        ['object']: schemaobjectModule.module
    },
})
