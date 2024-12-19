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
    devices: IDeviceTree[];
}

interface IDeviceTree {
    category_id: number;
    commands: IDeviceCommand[];
    connected_thru: number|null
    description: string;
    icon_name: string;
    id: number;
    inputs: 0;
    keycode: string;
    local_inputs: number;
    local_outputs: number;
    model_description: string;
    model_id: number;
    model_name: number;
    name: string;
    remotes_max: number;
    devices: IDeviceTree[];
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
