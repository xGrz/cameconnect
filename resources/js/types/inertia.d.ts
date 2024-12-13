export interface IBaseResponse extends Record<string, any> {
    isLoggedIn: boolean;
}


export interface IHomeResponse extends IBaseResponse {
    siteList: ISiteTree[];
}

interface ISiteTree {
    id: number;
    name: string;
    description: string;
    children: IDeviceTree[];
}

interface IDeviceTree {
    categoryId: number;
    children: IDeviceTree[];
    commandable: boolean;
    commands: IDeviceCommand[];
    description: string;
    iconName: string;
    id: number;
    inputs: 0;
    isAutomation: boolean;
    keyCode: string;
    model: number;
    modelId: number;
    modelName: string;
    name: string;
    online: boolean;
    outputs: number;
    parentId: number|null;
    remotesMax: number;
    states: any;
}

interface IDeviceCommand {
    commandId: number;
    deviceId: number;
    isAutomation: boolean;
    label: string;
}

interface IFavoriteCommand {
    command: number;
    device: number;
    deviceName: string;
    deviceDescription: string;
    iconName: string;
    isAutomation: boolean;
    label: string;

}
