import type { IWorkspace } from "@/entities";
import type { EObjectTypes } from "../enums";

export interface ISchemaobject {
    objectId: number;
    objectType: EObjectTypes;
    objectLocationX: number;
    objectLocationY: number;
    objectHeigth: number;
    objectWeigth: number;
    workspaceId: IWorkspace;
}