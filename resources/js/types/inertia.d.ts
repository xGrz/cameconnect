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
    connected_thru: number | null
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
    id: number;
    device_id: number;
    automation: boolean;
    command: number;
    label: string;
    system_name: string;
}

interface IDeviceFavoriteCommand {
    commands: IFavoriteCommand[];
    description: string;
    id: number;
    name: string;
    path: IFavouriteCommandPathItem[]
}

interface IFavoriteCommand {
    commandId: number;
    label: string;
    system_name: string|null;
}

interface IFavouriteCommandPathItem {
    description: string;
    deviceId: number;
    name: string;
}
